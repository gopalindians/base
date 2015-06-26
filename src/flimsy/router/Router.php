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
			$path = @parse_url($_SERVER['REQUEST_URI'])['path'];
			$path = preg_replace('~/?'.$this->basePath.'/?~i', '', $path);
		}
		catch(Exception $e){
			throw new RoutePathException();
		}

		if(!isset($this->routes[$path])){
			throw new RouteUnresolvedException($path);
		}
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
?>
