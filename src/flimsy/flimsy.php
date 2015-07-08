<?php

namespace flimsy;
/**
 * Includes required flimsy classes, will be registered as an autoload function in this file.
 * You must set FLIMSY_ROOT constant in order to make this work!
 *
 * @return void
 */
function autoload($class){
	$class = explode('\\', $class);
	$class = end($class);
	$path = constant('FLIMSY_ROOT').'/';
	$file = '';

	if(file_exists($file = $path.'php/db/'.$class.'.php')){
		require_once $file;
	}
	else if(file_exists($file = $path.'php/mvc/'.$class.'.php')){
		require_once $file;
	}
	else if(file_exists($file = $path.'php/router/'.$class.'.php')){
		require_once $file;
	}
}

spl_autoload_register('flimsy\autoload');
?>

