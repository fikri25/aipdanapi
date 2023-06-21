<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class RtfHtml
  {
    public function Format($root)
    {
      $this->output = "";
      // Create a stack of states:
      $this->states = array();
      // Put an initial standard state onto the stack:
      $this->state = new RtfState();
      array_push($this->states, $this->state);
      $this->FormatGroup($root);
      return $this->output;
    }
 
    protected function FormatGroup($group)
    {
      // Can we ignore this group?
      if ($group->GetType() == "fonttbl") return;
      if ($group->GetType() == "colortbl") return;
      if ($group->GetType() == "stylesheet") return;
      if ($group->GetType() == "info") return;
      // Skip any pictures:
      if (substr($group->GetType(), 0, 4) == "pict") return;
      if ($group->IsDestination()) return;
 
      // Push a new state onto the stack:
      $this->state = clone $this->state;
      array_push($this->states, $this->state);
 
      foreach($group->children as $child)
      {
        if(get_class($child) == "RtfGroup") $this->FormatGroup($child);
        if(get_class($child) == "RtfControlWord") $this->FormatControlWord($child);
        if(get_class($child) == "RtfControlSymbol") $this->FormatControlSymbol($child);
        if(get_class($child) == "RtfText") $this->FormatText($child);
      }
 
      // Pop state from stack.
      array_pop($this->states);
      $this->state = $this->states[sizeof($this->states)-1];
    }
 
    protected function FormatControlWord($word)
    {
      if($word->word == "plain") $this->state->Reset();
      if($word->word == "b") $this->state->bold = $word->parameter;
      if($word->word == "i") $this->state->italic = $word->parameter;
      if($word->word == "ul") $this->state->underline = $word->parameter;
      if($word->word == "ulnone") $this->state->end_underline = $word->parameter;
      if($word->word == "strike") $this->state->strike = $word->parameter;
      if($word->word == "v") $this->state->hidden = $word->parameter;
      if($word->word == "fs") $this->state->fontsize = ceil(($word->parameter / 24) * 16);
 
      if($word->word == "par") $this->output .= "<p>";
 
      // Characters:
      if($word->word == "lquote") $this->output .= "&lsquo;";
      if($word->word == "rquote") $this->output .= "&rsquo;";
      if($word->word == "ldblquote") $this->output .= "&ldquo;";
      if($word->word == "rdblquote") $this->output .= "&rdquo;";
      if($word->word == "emdash") $this->output .= "&mdash;";
      if($word->word == "endash") $this->output .= "&ndash;";
      if($word->word == "bullet") $this->output .= "&bull;";
      if($word->word == "u") $this->output .= "&loz;";
    }
 
    protected function BeginState()
    {
      $span = "";
      if($this->state->bold) $span .= "font-weight:bold;";
      if($this->state->italic) $span .= "font-style:italic;";
      if($this->state->underline) $span .= "text-decoration:underline;";
      if($this->state->end_underline) $span .= "text-decoration:none;";
      if($this->state->strike) $span .= "text-decoration:strikethrough;";
      if($this->state->hidden) $span .= "display:none;";
      if($this->state->fontsize != 0) $span .= "font-size: {$this->state->fontsize}px;";
      $this->output .= "<span style='{$span}'>";
    }
 
    protected function EndState()
    {
      $this->output .= "</span>";
    }
 
    protected function FormatControlSymbol($symbol)
    {
      if($symbol->symbol == '\'')
      {
        $this->BeginState();
        $this->output .= htmlentities(chr($symbol->parameter), ENT_QUOTES, 'ISO-8859-1');
        $this->EndState();
      }
    }
 
    protected function FormatText($text)
    {
      $this->BeginState();
      $this->output .= $text->text;
      $this->EndState();
    }
  }
