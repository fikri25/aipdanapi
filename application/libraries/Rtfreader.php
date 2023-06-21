<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class RtfElement
  {
    protected function Indent($level)
    {
      for($i = 0; $i < $level * 2; $i++) echo "&nbsp;";
    }
  }
 
  class RtfGroup extends RtfElement
  {
    public $parent;
    public $children;
 
    public function __construct()
    {
      $this->parent = null;
      $this->children = array();
    }
 
    public function GetType()
    {
      // No children?
      if(sizeof($this->children) == 0) return null;
      // First child not a control word?
      $child = $this->children[0];
      if(get_class($child) != "RtfControlWord") return null;
      return $child->word;
    }    
 
    public function IsDestination()
    {
      // No children?
      if(sizeof($this->children) == 0) return null;
      // First child not a control symbol?
      $child = $this->children[0];
      if(get_class($child) != "RtfControlSymbol") return null;
      return $child->symbol == '*';
    }
 
    public function dump($level = 0)
    {
      echo "<div>";
      $this->Indent($level);
      echo "{";
      echo "</div>";
 
      foreach($this->children as $child)
      {
        if(get_class($child) == "RtfGroup")
        {
          if ($child->GetType() == "fonttbl") continue;
          if ($child->GetType() == "colortbl") continue;
          if ($child->GetType() == "stylesheet") continue;
          if ($child->GetType() == "info") continue;
          // Skip any pictures:
          if (substr($child->GetType(), 0, 4) == "pict") continue;
          if ($child->IsDestination()) continue;
        }
        $child->dump($level + 2);
      }
 
      echo "<div>";
      $this->Indent($level);
      echo "}";
      echo "</div>";
    }
  }
 
  class RtfControlWord extends RtfElement
  {
    public $word;
    public $parameter;
 
    public function dump($level)
    {
      echo "<div style='color:green'>";
      $this->Indent($level);
      echo "WORD {$this->word} ({$this->parameter})";
      echo "</div>";
    }
  }
 
  class RtfControlSymbol extends RtfElement
  {
    public $symbol;
    public $parameter = 0;
 
    public function dump($level)
    {
      echo "<div style='color:blue'>";
      $this->Indent($level);
      echo "SYMBOL {$this->symbol} ({$this->parameter})";
      echo "</div>";
    }    
  }
 
  class RtfText extends RtfElement
  {
    public $text;
 
    public function dump($level)
    {
      echo "<div style='color:red'>";
      $this->Indent($level);
      echo "TEXT {$this->text}";
      echo "</div>";
    }    
  }
 
  class RtfReader
  {
    public $root = null;
 
    protected function GetChar()
    {
      $this->char = $this->rtf[$this->pos++];
    }
 
    protected function ParseStartGroup()
    {
      // Store state of document on stack.
      $group = new RtfGroup();
      if($this->group != null) $group->parent = $this->group;
      if($this->root == null)
      {
        $this->group = $group;
        $this->root = $group;
      }
      else
      {
        array_push($this->group->children, $group);
        $this->group = $group;
      }
    }
 
    protected function is_letter()
    {
      if(ord($this->char) >= 65 && ord($this->char) <= 90) return TRUE;
      if(ord($this->char) >= 90 && ord($this->char) <= 122) return TRUE;
      return FALSE;
    }
 
    protected function is_digit()
    {
      if(ord($this->char) >= 48 && ord($this->char) <= 57) return TRUE;
      return FALSE;
    }
 
    protected function ParseEndGroup()
    {
      // Retrieve state of document from stack.
      $this->group = $this->group->parent;
    }
 
    protected function ParseControlWord()
    {
      $this->GetChar();
      $word = "";
      while($this->is_letter())
      {
        $word .= $this->char;
        $this->GetChar();
      }
 
      // Read parameter (if any) consisting of digits.
      // Paramater may be negative.
      $parameter = null;
      $negative = false;
      if($this->char == '-') 
      {
        $this->GetChar();
        $negative = true;
      }
      while($this->is_digit())
      {
        if($parameter == null) $parameter = 0;
        $parameter = $parameter * 10 + $this->char;
        $this->GetChar();
      }
      if($parameter === null) $parameter = 1;
      if($negative) $parameter = -$parameter;
 
      // If this is \u, then the parameter will be followed by 
      // a character.
      if($word == "u") 
      {
      }
      // If the current character is a space, then
      // it is a delimiter. It is consumed.
      // If it's not a space, then it's part of the next
      // item in the text, so put the character back.
      else
      {
        if($this->char != ' ') $this->pos--; 
      }
 
      $rtfword = new RtfControlWord();
      $rtfword->word = $word;
      $rtfword->parameter = $parameter;
      array_push($this->group->children, $rtfword);
    }
 
    protected function ParseControlSymbol()
    {
      // Read symbol (one character only).
      $this->GetChar();
      $symbol = $this->char;
 
      // Symbols ordinarily have no parameter. However, 
      // if this is \', then it is followed by a 2-digit hex-code:
      $parameter = 0;
      if($symbol == '\'')
      {
        $this->GetChar(); 
        $parameter = $this->char;
        $this->GetChar(); 
        $parameter = hexdec($parameter . $this->char);
      }
 
      $rtfsymbol = new RtfControlSymbol();
      $rtfsymbol->symbol = $symbol;
      $rtfsymbol->parameter = $parameter;
      array_push($this->group->children, $rtfsymbol);
    }
 
    protected function ParseControl()
    {
      // Beginning of an RTF control word or control symbol.
      // Look ahead by one character to see if it starts with
      // a letter (control world) or another symbol (control symbol):
      $this->GetChar();
      $this->pos--;
      if($this->is_letter()) 
        $this->ParseControlWord();
      else
        $this->ParseControlSymbol();
    }
 
    protected function ParseText()
    {
      // Parse plain text up to backslash or brace,
      // unless escaped.
      $text = "";
 
      do
      {
        $terminate = false;
        $escape = false;
 
        // Is this an escape?
        if($this->char == '\\')
        {
          // Perform lookahead to see if this
          // is really an escape sequence.
          $this->GetChar();
          switch($this->char)
          {
            case '\\': $text .= '\\'; break;
            case '{': $text .= '{'; break;
            case '}': $text .= '}'; break;
            default:
              // Not an escape. Roll back.
              $this->pos = $this->pos - 2;
              $terminate = true;
              break;
          }
        }
        else if($this->char == '{' || $this->char == '}')
        {
          $this->pos--;
          $terminate = true;
        }
 
        if(!$terminate && !$escape)
        {
          $text .= $this->char;
          $this->GetChar();
        }
      }
      while(!$terminate && $this->pos < $this->len);
 
      $rtftext = new RtfText();
      $rtftext->text = $text;
      array_push($this->group->children, $rtftext);
    }
 
    public function Parse($rtf)
    {
      $this->rtf = $rtf;
      $this->pos = 0;
      $this->len = strlen($this->rtf);
      $this->group = null;
      $this->root = null;
 
      while($this->pos < $this->len)
      {
        // Read next character:
        $this->GetChar();
 
        // Ignore \r and \n
        if($this->char == "\n" || $this->char == "\r") continue;
 
        // What type of character is this?
        switch($this->char)
        {
          case '{':
            $this->ParseStartGroup();
            break;
          case '}':
            $this->ParseEndGroup();
            break;
          case '\\':
            $this->ParseControl();
            break;
          default:
            $this->ParseText();
            break;
        }
      }
    }
  }
 
  class RtfState
  {
    public function __construct()
    {
      $this->Reset();
    }
 
    public function Reset()
    {
      $this->bold = false;
      $this->italic = false;
      $this->underline = false;
      $this->end_underline = false;
      $this->strike = false;
      $this->hidden = false;
      $this->fontsize = 0;
    }
  }
 

