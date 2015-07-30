<?php

namespace base;

require_once 'mock/ControllerMock.php';
require_once 'mock/ControllerParamsMock.php';
require_once 'mock/RouterMock.php';
require_once 'mock/ViewParamsMock.php';
require_once 'mock/ViewResolveMock.php';

class TestRouter extends TestCase{
	const BASE_PATH = '/base/src/test';
	const ROUTE_FILE = 'data/test_router.json';
	const ROUTER_BASE = '/base/src/test';

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

	function testLoadRoutingFromFile(){
		$controllerParams = array('param0' => 123, 'param1' => 'foo');
		$viewParams = array();

		$this->router->loadRouting(self::ROUTE_FILE, $controllerParams, $viewParams);

		assertNotNull('Route must not be null a.', $this->router->get('/a'));
		assertNotNull('Route must not be null b.', $this->router->get('b'));
		assertNotNull('Route must not be null c.', $this->router->get('/c/x/y'));
		assertNotNull('Route must not be null d.', $this->router->get('/d/foo/bar'));
		assertNotNull('Route must not be null e.', $this->router->get('/e'));
		assertNotNull('Route must not be null f.', $this->router->get('/f'));
		assertNotNull('Route must not be null g.', $this->router->get('/g'));

		$e = $this->router->get('/e')->getController();
		$g = $this->router->get('/g')->getController();

		assertContainsKey('param0 must be contained e.', $e->params, 'param0');
		assertContainsKey('param1 must be contained e.', $e->params, 'param1');
		assertEqual('Params must be equal e.', $e->params['param0'], $controllerParams['param0']);
		assertEqual('Params must be equal e.', $e->params['param1'], $controllerParams['param1']);

		assertContainsKey('param0 must be contained g.', $g->params, 'param0');
		assertContainsKey('param1 must be contained g.', $g->params, 'param1');

		// cannot test for view params, since controller returns base class View
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

	function testTriggeringRoute(){
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

	private function testView(&$router, $resolve, $expected){
		try{
			$router->resolve($resolve);
		}
		catch(\Exception $e){
			assertEqual('Expected '.$expected.' but was '.$e->getMessage(), $e->getMessage(), $expected);
		}
	}

	function testResolve(){
		$router = new \RouterMock();

		$router->when('/simple',
					  self::$get,
					  new StaticController(new \ViewResolveMock('a')));

		$router->when('still_simple',
					  self::$get,
					  new StaticController(new \ViewResolveMock('b')));

		$router->when('////more///complex///',
					  self::$get,
					  new StaticController(new \ViewResolveMock('c')));

		$router->when('/with/params/:a/:b',
					  self::$get,
					  new StaticController(new \ViewResolveMock('d')));

		$router->when('with///optional/params//:x?////:y?//',
					  self::$get,
					  new StaticController(new \ViewResolveMock('e')));

		$router->when('/otherwise',
					  self::$get,
					  new StaticController(new \ViewResolveMock('f')));

		$router->otherwise('/otherwise'); // not tested yet, since hard to mock

		assertNotNull('Route must exists /simpe.', $router->get('/simple'));

		$this->testView($router, '/simple', 'a');
		$this->testView($router, '/still_simple', 'b');
		$this->testView($router, 'more/complex', 'c');
		$this->testView($router, '///with///params//:1:/:2', 'd');
		$this->testView($router, '/with/optional/params/', 'e');
		$this->testView($router, '/with/optional/params/:1', 'e');
		$this->testView($router, '/with/optional/params/:1/:2', 'e');
	}

	function testGetPath(){
		$router = new Router(SELF::ROUTER_BASE);
		assertEqual('Base path must be stripped.', $router->getPath()->getRoute(), '/');
	}
}
?>
