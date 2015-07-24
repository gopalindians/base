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
$controllerParams = array('welcome' => 'Mr. X');
$viewParams = array('some_var' => 'This is some data!');

$router = new base\Router('base/src/test');
$router->loadRouting('routing.json', $controllerParams, $viewParams);

$router->when('/form',
			  array('POST'),
			  new FormController());

$router->when('on//deep////route///',
			  array('GET'),
			  new base\StaticController(new DeepView()));

$router->when('/triggerMe',
			  array('POST'),
			  new TriggerController());

$router->when('/404',
			  array('GET', 'POST'),
			  new Error404Controller());

$router->otherwise('/404');

$router->trigger('/triggerMe', array('POST')); // always trigger

try{
	$router->resolve();
}
catch(base\RouterPathException $e){
	exception($e);
}
catch(base\RouteUnresolvedException $e){
	exception($e);
}

// TESTS:
require_once 'test_email.php';
require_once 'test_pdo.php';
?>
