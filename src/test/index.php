<?php
define('FLIMSY_ROOT', '../flimsy');

require_once '../flimsy/flimsy.php';
require_once 'autoload.php';

function exception($e){
	print $e->getCode().': '.$e->getMessage();
	exit;
}

// setup database connection
$db = new MySQL('localhost', 'root', '', 'flimsy');

// setup router
$router = new Router('flimsy/src/test');

$router->when('/:welcome?/:nr?',
			  array('GET'),
			  new HomeController(new HomeView()));

$router->when('/about/',
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
catch(RouterPathException $e){
	exception($e);
}
catch(RouteUnresolvedException $e){
	exception($e);
}
catch(RouteUnacceptedRequestException $e){
	exception($e);
}
?>
