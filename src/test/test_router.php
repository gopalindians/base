<?php

namespace base;

require_once 'mock/ControllerMock.php';

class TestRouter extends TestCase{
	const BASE_PATH = '/base/src/test';
	const ROUTE_FILE = 'data/test_router.json';

	private $router;
	private static $get = array('GET');
	private $staticController;

	function __construct(){
		parent::__construct('Router test');
	}

	function prepare(){
		$this->staticController = new StaticController(null);
	}

	function setup(){
		$this->router = new Router(self::BASE_PATH);
	}

	function cleanup(){
		
	}

	function testLoadRouting(){
		$controllerParams = array();
		$viewParams = array();

		$this->router->loadRouting(self::ROUTE_FILE, $controllerParams, $viewParams);
	}

	function testConflictingRoutes(){
		assertTrue('1 route must be added.', $this->router->when('/same', self::$get, $this->staticController));
		assertFalse('2 route must not be added.', $this->router->when('same', self::$get, $this->staticController));

		assertTrue('3 route must be added.', $this->router->when('/other/:abc/:def', self::$get, $this->staticController));
		assertTrue('4 route must not be added.', $this->router->when('/other', self::$get, $this->staticController));

		assertTrue('5 route must be added.', $this->router->when('/last/:param0/:param1?', self::$get, $this->staticController));
		assertFalse('6 route must not be added.', $this->router->when('/last/:param0/:param1?', self::$get, $this->staticController));
	}

	function testRouteManagement(){
		assertTrue('Route must be added.', $this->router->when('/other', self::$get, $this->staticController));
		assertNotNull('Route must be returned.', $this->router->get('/other'));
		assertNull('Route must not be returned.', $this->router->get('/different'));
		$this->router->remove('/other');
		$this->router->when('different', self::$get, $this->staticController);
		assertNull('Route must not be returned.', $this->router->get('/other'));
		assertNotNull('Route must be returned.', $this->router->get('/different'));
	}

	function testRoute(){
		assertEqual('Routes must be equal.', $this->router->getPath(), '/base/src/test');
	}

	function testTrigger(){
		$controller = new \ControllerMock();

		$this->router->when('/trigger', HttpMethod::ALL(), $controller);
		$this->router->trigger('/trigger', array(HttpMethod::GET));
		$this->router->trigger('/trigger', array(HttpMethod::POST));
		$this->router->trigger('/trigger', array(HttpMethod::PUT));
		$this->router->trigger('/trigger', array(HttpMethod::DELETE));
		$this->router->trigger('/trigger', array(HttpMethod::HEAD));
		$this->router->trigger('/trigger', array(HttpMethod::TRACE));
		$this->router->trigger('/trigger', array(HttpMethod::CONNECT));

		assertTrue('GET must have been called.', $controller->resolveGetCalled);
		assertTrue('POST must have been called.', $controller->resolvePostCalled);
		assertTrue('PUT must have been called.', $controller->resolvePutCalled);
		assertTrue('DELETE must have been called.', $controller->resolveDeleteCalled);
		assertTrue('HEAD must have been called.', $controller->resolveHeadCalled);
		assertTrue('TRACE must have been called.', $controller->resolveTraceCalled);
		assertTrue('CONNECT must have been called.', $controller->resolveConnectCalled);
	}

	function testResolve(){

	}
}
?>
