<?php

namespace base;

/**
 * Class for server side routing.
 *
 * @author Marvin Blum
 */
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
		catch(\Exception $e){
			$this->resolveWithoutRedirect($this->redirect);
		}
	}

	private function resolveWithoutRedirect($url = null){
		try{
			if(!$url){
				$route = preg_replace('~/?'.$this->basePath.'~i', '', $_SERVER['REQUEST_URI']);
			}
			else{
				$route = $url;
			}
		}
		catch(\Exception $e){
			throw new RoutePathException();
		}

		foreach($this->routes AS $value){
			if($value->matches($route) && in_array($_SERVER['REQUEST_METHOD'], $value->getRequestMethods())){
				switch($_SERVER['REQUEST_METHOD']){
					case HttpMethod::GET:
						$value->getController()->resolveGET($value->getParams(), $_SERVER['REQUEST_METHOD']);
						break;
					case HttpMethod::POST:
						$value->getController()->resolvePOST($value->getParams(), $_SERVER['REQUEST_METHOD']);
						break;
					case HttpMethod::PUT:
						$value->getController()->resolvePUT($value->getParams(), $_SERVER['REQUEST_METHOD']);
						break;
					case HttpMethod::DELETE:
						$value->getController()->resolveDELETE($value->getParams(), $_SERVER['REQUEST_METHOD']);
						break;
					case HttpMethod::HEAD:
						$value->getController()->resolveHEAD($value->getParams(), $_SERVER['REQUEST_METHOD']);
						break;
					case HttpMethod::TRACE:
						$value->getController()->resolveTRACE($value->getParams(), $_SERVER['REQUEST_METHOD']);
						break;
					case HttpMethod::CONNECT:
						$value->getController()->resolveCONNECT($value->getParams(), $_SERVER['REQUEST_METHOD']);
						break;
				}

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
?>

