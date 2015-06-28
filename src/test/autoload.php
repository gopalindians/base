<?php
function web_exp_autoload($class){
	$file = '';

	if(file_exists($file = 'control/'.$class.'.php')){
		require_once $file;
	}
	else if(file_exists($file = 'view/'.$class.'.php')){
		require_once $file;
	}
}

spl_autoload_register('web_exp_autoload');
?>
