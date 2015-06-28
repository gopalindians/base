This sample does not work yet!

<?php
exit;

session_start();

define('FLIMSY_ROOT', 'lib/flimsy');

require_once 'lib/flimsy/flimsy.php';

function exception($e){
	print $e->getCode().': '.$e->getMessage();
	exit;
}

// connect to database
try{
	$db = new MySQL('localhost', 'root', '', 'oop');
}
catch(Exception $e){
	exception($e);
}

// setup router
$router = new Router('web_exp');

$router->when('/:welcome?/:nr?',
			  array('GET'),
			  new HomeController(new HomeView($smarty, 'template/layout.html')));

$router->when('/about/',
			  array('GET'),
			  new AboutController(new AboutView($smarty, 'template/layout.html')));

$router->when('/form',
			  array('POST'),
			  new FormController());

$router->when('/404',
			  array('GET'),
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
