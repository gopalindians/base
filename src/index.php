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
$router = new Router('web_exp');

$router->attach(new Route());
$router->attach(new Route('about'));

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

// create view and display page
/*require_once 'control/HomeController.php';
require_once 'view/HomeView.php';

$controller = new HomeController();
$view = new HomeView($controller, $smarty, 'template/layout.html');

$controller->exec();

try{
    $view->display();
}
catch(ViewNotFound $e){
    print '#404: '.$e->getMessage();
}*/
?>
