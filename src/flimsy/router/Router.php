<?php
class Router{
	private $routes = array();
	private $basePath = '';
	private $redirect = null;

	/**
	 * Constructor.
	 *
	 * @param basePath optional base path, required to ignore part of routes (URL)
	 */
	function __construct($basePath = ''){
		$this->basePath = $basePath;
	}

	/**
	 * Registers a new route.
	 *
	 * @param route the route to resolve
	 * @see Route constructor
	 * @param method array of allowed methods
	 * @see Route constructor
	 * @param controller the controller for this route
	 * @see Route constructor
	 */
	function when($route, array $method, Controller $controller){
		if(isset($this->routes[$route])){
			return false;
		}

		$this->routes[$route] = new Route($route, $method, $controller);

		return true;
	}

	/**
	 * Alternative routing, if a route cannot be resolved.
	 * If the alternative route cannot be resolved, an exception will be thrown.
	 *
	 * @param route alternative route
	 */
	function otherwise($route){
		$this->redirect = $route;
	}

	/**
	 * Returns a Route object by route.
	 *
	 * @return Route
	 */
	function get($route){
		if(!isset($this->routes[$route])){
			return null;
		}

		return $this->routes[$route];
	}

	/**
	 * Removes a route to resolve.
	 *
	 * @return void
	 */
	function remove($route){
		if(isset($this->routes[$route])){
			unset($this->routes[$route]);
		}
	}

	private function resolveWithRedirect(){
		try{
			$this->resolveWithoutRedirect();
		}
		catch(Exception $e){
			$this->resolveWithoutRedirect($this->redirect);
		}
	}

	private function resolveWithoutRedirect($url = null){
		try{
			if(!$url){
				$route = @parse_url($_SERVER['REQUEST_URI'])['path'];
				$route = preg_replace('~/?'.$this->basePath.'~i', '', $route);
			}
			else{
				$route = $url;
			}
		}
		catch(Exception $e){
			throw new RoutePathException();
		}

		foreach($this->routes AS $value){
			if($value->matches($route) && in_array($_SERVER['REQUEST_METHOD'], $value->getRequestMethods())){
				$value->getController()->exec($value->getParams(), $_SERVER['REQUEST_METHOD']);
				return;
			}
		}

		throw new RouteUnresolvedException($route);
	}

	/**
	 * Resolves current URL.
	 *
	 * @return void
	 * @throws RoutePathException, RouteUnresolvedException, RouteUnacceptedRequestException
	 */
	function resolve(){
		if($this->redirect){
			$this->resolveWithRedirect();
		}
		else{
			$this->resolveWithoutRedirect();
		}
	}
}

class RoutePathException extends Exception{
	const MESSAGE = 'Could not parse URL, resolving route is not possible.';
	const CODE = 1;

	function __construct(){
		Exception::__construct(RouterPathException::MESSAGE, RoutePathException::CODE);
	}
}

class RouteUnresolvedException extends Exception{
	const MESSAGE = 'The URL could not be resolved to a route: ';
	const CODE = 2;

	function __construct($url = ''){
		Exception::__construct(RouteUnresolvedException::MESSAGE.$url, RouteUnresolvedException::CODE);
	}
}
?>
