<?php
define('BASE_ROOT', '../base');

require_once '../base/base.php';
require_once 'autoload.php';

function exception($e){
	print $e->getCode().': '.$e->getMessage();
	exit;
}

// setup database connection
$db = new base\MySQL('localhost', 'root', '', 'base');

// setup router
$router = new base\Router('base/src/test');

$router->when('/:welcome?/:nr?/',
			  array('GET', 'POST'),
			  new HomeController(new HomeView()));

$router->when('/about',
			  array('GET'),
			  new AboutController(new AboutView()));

$router->when('/form',
			  array('POST'),
			  new FormController());

$router->when('/404',
			  array('GET', 'POST'),
			  new Error404Controller());

$router->otherwise('/404');

try{
	$router->resolve();
}
catch(base\RouterPathException $e){
	exception($e);
}
catch(base\RouteUnresolvedException $e){
	exception($e);
}
?>
