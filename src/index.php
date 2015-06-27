<?php
session_start();

define('FLIMSY_ROOT', 'lib/flimsy');

require_once 'lib/smarty/Smarty.class.php';
require_once 'lib/flimsy/flimsy.php';

// setup smarty
$smarty = new Smarty();
$smarty->template_dir = 'template';
$smarty->compile_dir = 'template_c';
$smarty->cache_dir = 'cache';

// connect to database
try{
	$db = new MySQL('localhost', 'root', '', 'oop');
}
catch(Exception $e){
	print $e->getMessage();
	exit;
}

// setup router
require_once 'control/HomeController.php';
require_once 'view/HomeView.php';

$router = new Router('web_exp');

$router->attach(new Route('/',
				array('GET'),
				new HomeController(new HomeView($smarty, 'template/layout.html'))));

$router->attach(new Route('/about',
				array('GET'),
				new HomeController(new HomeView($smarty, 'template/layout.html'))));

try{
	$router->resolve();
}
catch(RouterPathException $e){
	print $e->getMessage();
	exit;
}
catch(RouteUnresolvedException $e){
	print $e->getMessage();
	exit;
}
catch(RouteUnacceptedRequestException $e){
	print $e->getMessage();
	exit;
}
?>
