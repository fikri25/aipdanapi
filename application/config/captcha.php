<?php
// BotDetect PHP Captcha configuration options

$config = array(
  // Captcha configuration for example page
  'ExampleCaptcha' => array(
    'UserInputID' => 'CaptchaCode',
    'CodeLength' => CaptchaRandomization::GetRandomCodeLength(4, 6),
    'ImageStyle' => array(
	      ImageStyle::Radar,
	      ImageStyle::Collage,
	      ImageStyle::Fingerprints,
	    ),
    'ImageWidth' => 100,
    'ImageHeight' => 40,
  ),

);