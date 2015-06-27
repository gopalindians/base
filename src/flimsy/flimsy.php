<?php
/**
 * Includes required flimsy classes, will be registered as an autoload function in this file.
 * You must set FLIMSY_ROOT constant in order to make this work!
 *
 * @return void
 */
function flimsy_autoload($class){
	$path = constant('FLIMSY_ROOT').'/';
	$file = '';

	if(file_exists($file = $path.'db/'.$class.'.php')){
		require_once $file;
	}
	else if(file_exists($file = $path.'mvc/'.$class.'.php')){
		require_once $file;
	}
	else if(file_exists($file = $path.'router/'.$class.'.php')){
		require_once $file;
	}
}

spl_autoload_register('flimsy_autoload');
?>
