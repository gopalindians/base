<?php
require_once 'mock/ControllerMock.php';

class TestRouter extends base\TestCase{
	const BASE_PATH = '/base/src/test';
	const ROUTE_FILE = 'data/test_router.json';

	private $router;
	private static $get = array('GET');
	private $staticController;

	function __construct(){
		parent::__construct('Router test');
	}

	function prepare(){
		$this->staticController = new base\StaticController(null);
	}

	function setup(){
		$this->router = new base\Router(self::BASE_PATH);
	}

	function testLoadRouting(){
		$this->router->loadRouting(self::ROUTE_FILE, array(), array());
	}

	function testConflictingRoutes(){
		base\assertTrue('1 route must be added.', $this->router->when('/same', self::$get, $this->staticController));
		base\assertFalse('2 route must not be added.', $this->router->when('same', self::$get, $this->staticController));

		base\assertTrue('3 route must be added.', $this->router->when('/other/:abc/:def', self::$get, $this->staticController));
		base\assertTrue('4 route must not be added.', $this->router->when('/other', self::$get, $this->staticController));

		base\assertTrue('5 route must be added.', $this->router->when('/last/:param0/:param1?', self::$get, $this->staticController));
		base\assertFalse('6 route must not be added.', $this->router->when('/last/:param0/:param1?', self::$get, $this->staticController));
	}

	function testRouteManagement(){
		base\assertTrue('Route must be added.', $this->router->when('/other', self::$get, $this->staticController));
		base\assertNotNull('Route must be returned.', $this->router->get('/other'));
		base\assertNull('Route must not be returned.', $this->router->get('/different'));
		$this->router->remove('/other');
		$this->router->when('different', self::$get, $this->staticController);
		base\assertNull('Route must not be returned.', $this->router->get('/other'));
		base\assertNotNull('Route must be returned.', $this->router->get('/different'));
	}

	function testRoute(){
		base\assertEqual('Routes must be equal.', $this->router->getPath(), '/base/src/test');
	}

	function testTrigger(){
		$controller = new ControllerMock();

		$this->router->when('/trigger', base\HttpMethod::ALL(), $controller);
		$this->router->trigger('/trigger', array(base\HttpMethod::GET));
		$this->router->trigger('/trigger', array(base\HttpMethod::POST));
		$this->router->trigger('/trigger', array(base\HttpMethod::PUT));
		$this->router->trigger('/trigger', array(base\HttpMethod::DELETE));
		$this->router->trigger('/trigger', array(base\HttpMethod::HEAD));
		$this->router->trigger('/trigger', array(base\HttpMethod::TRACE));
		$this->router->trigger('/trigger', array(base\HttpMethod::CONNECT));

		base\assertTrue('GET must have been called.', $controller->resolveGetCalled);
		base\assertTrue('POST must have been called.', $controller->resolvePostCalled);
		base\assertTrue('PUT must have been called.', $controller->resolvePutCalled);
		base\assertTrue('DELETE must have been called.', $controller->resolveDeleteCalled);
		base\assertTrue('HEAD must have been called.', $controller->resolveHeadCalled);
		base\assertTrue('TRACE must have been called.', $controller->resolveTraceCalled);
		base\assertTrue('CONNECT must have been called.', $controller->resolveConnectCalled);
	}

	function testResolve(){

	}
}
?>
