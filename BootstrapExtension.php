<?php

$wgExtensionFunctions[] = "BootstrapSetup";
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Bootstrap',
	'author' => 'Aaron Parecki',
	'description' => 'Adds <nowiki><span6></nowiki> tags to support Bootstrap layouts',
	'url' => 'https://github.com/aaronpk/Bootstrap-Skin'
);

function BootstrapSetup() {
    global $wgParser;

    for($i=1; $i<=16; $i++)
	    $wgParser->setHook('span'.$i, array('BootstrapExtension','span'.$i));
    $wgParser->setHook('span-one-third', array('BootstrapExtension','span-one-third'));
    $wgParser->setHook('span-two-thirds', array('BootstrapExtension','span-two-thirds'));
    $wgParser->setHook('row', array('BootstrapExtension','row'));
    $wgParser->setHook('mediagrid', array('BootstrapExtension','mediagrid'));
} 

class BootstrapExtension {

  public static function mediagrid() 
  {
    
  }

	public static function __callStatic($name, $fargs)
	{
		global $wgParser;

		$input = $fargs[0];

		$class = FALSE;
		if(is_array($fargs[1])) {
			if(array_key_exists('class', $fargs[1])) {
				$class = $fargs[1]['class'];
			}
		}

		return '<div class="' . $name . ($class?' '.$class:'') . '">' . $wgParser->recursiveTagParse($input) . '</div>';
	}

}

