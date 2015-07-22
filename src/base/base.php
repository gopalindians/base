<?php

namespace base;

/**
 * Includes required base classes, will be registered as an autoload function in this file.
 * You must set BASE_ROOT constant in order to make this work!
 *
 * @return void
 */
function autoload($class){
	$class = explode('\\', $class);
	$class = end($class);
	$path = constant('BASE_ROOT').'/';
	$file = '';

	if(file_exists($file = $path.'php/driver/'.$class.'.php')){
		require_once $file;
	}
	else if(file_exists($file = $path.'php/mvc/'.$class.'.php')){
		require_once $file;
	}
	else if(file_exists($file = $path.'php/router/'.$class.'.php')){
		require_once $file;
	}
	else if(file_exists($file = $path.'php/exceptions/'.$class.'.php')){
		require_once $file;
	}
	else if(file_exists($file = $path.'php/util/'.$class.'.php')){
		require_once $file;
	}
}

spl_autoload_register('base\autoload');

// function includes
require_once constant('BASE_ROOT').'/php/util/dump.php';
?>
