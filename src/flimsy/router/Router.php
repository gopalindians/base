<?php

class Router{
	private $routes = array();
	private $basePath = '';

	function __construct($basePath = ''){
		$this->basePath = $basePath;
	}

	function attach(Route $route){
		if(isset($this->routes[$route->getRoute()])){
			return false;
		}

		$this->routes[$route->getRoute()] = $route;

		return true;
	}

	function get($route){
		if(!isset($this->routes[$route])){
			return null;
		}

		return $this->routes[$route];
	}

	function remove($route){
		if(isset($this->routes[$route])){
			unset($this->routes[$route]);
		}
	}

	function resolve(){
		try{
			$route = @parse_url(trim($_SERVER['REQUEST_URI'], '/'))['path'];
			$route = preg_replace('~/?'.$this->basePath.'/?~i', '', $route);
		}
		catch(Exception $e){
			throw new RoutePathException();
		}

		if(!isset($this->routes[$route])){
			throw new RouteUnresolvedException($route);
		}

		if(!in_array($_SERVER['REQUEST_METHOD'], $this->routes[$route]->getRequestMethods())){
			throw new RouteUnacceptedRequestException($_SERVER['REQUEST_METHOD']);
		}

		$this->routes[$route]->getController()->exec();
	}
}

class RoutePathException extends Exception{
	const MESSAGE = 'Could not parse URL, resolving route is not possible.';

	function __construct(){
		Exception::__construct(RouterPathException::MESSAGE);
	}
}

class RouteUnresolvedException extends Exception{
	const MESSAGE = 'The URL could not be resolved to a route: ';

	function __construct($url = ''){
		Exception::__construct(RouteUnresolvedException::MESSAGE.$url);
	}
}

class RouteUnacceptedRequestException extends Exception{
	const MESSAGE = 'The route refused the request method: ';

	function __construct($method = ''){
		Exception::__construct(RouteUnacceptedRequestException::MESSAGE.$method);
	}
}
?>
