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

	private function getMethods($route){
		if(isset($route->methods)){
			return $route->methods;
		}

		return array(HttpMethod::GET);
	}

	private function getParams($params, $selection){
		$selected = array();

		foreach($selection AS $value){
			if(isset($params[$value])){
				$selected[$value] = $params[$value];
			}
		}

		return $selected;
	}

	private function getController($route, $controllorParamsSelection, $viewParamsSelection){
		$controllerParams = array();
		$viewParams = array();

		if(isset($route->controllerParams)){
			$controllerParams = $this->getParams($controllorParamsSelection, $route->controllerParams);
		}

		if(isset($route->viewParams)){
			$viewParams = $this->getParams($viewParamsSelection, $route->viewParams);
		}

		if(isset($route->view)){
			return new $route->controller($controllerParams, new $route->view($viewParams));
		}
		else{
			return new $route->controller($controllerParams);
		}
	}

	/**
	 * Reads a json configuration to set up routing.
	 * Json format:
	 *
	 * {[
	 *   {'when:'/route',
	 *    'methods':['GET', 'POST'],
	 *    'controller':'ControllerClassName',
	 *    'controllerParams':['controller', 'variable', 'names'],
	 *    'view':'ViewClassName',
	 *    'viewParams':['view', 'variable', 'names']}
	 * ]}
	 *
	 * Parameters will be passed as an associative array first, even if empty.
	 * The view will be allways passed last to the control.
	 * methods, controllerParams, view and viewParams are optional.
	 *
	 * @param file the file containing the json for routing
	 * @param controllerParams params used while setting up the controller (optional)
	 * @param viewParams params used while setting up the view (optional)
	 * @return void
	 */
	function loadRouting($file, array $controllerParams = array(), array $viewParams = array()){
		if(($content = @file_get_contents($file)) === FALSE){
			throw new RouteFileNotFoundException($file);
		}

		try{
			$data = @json_decode($content);
		}
		catch(\Exception $e){
			throw new RouteFileParseException($file);
		}

		if(!isset($data->routes) || !is_array($data->routes)){
			throw new RouteFileParseException($file);
		}

		foreach($data->routes AS $value){
			if(!isset($value->when) || !isset($value->controller)){
				throw new RouteFileParseException($file);
			}

			$this->when($value->when, // FIXME
						$this->getMethods($value),
						$this->getController($value, $controllerParams, $viewParams));
		}
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
	 * @return true, when the route was added, false if they existed already
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
	 * @return void
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

	/**
	 * Returns path to resolve. This is the URL without domain and base path.
	 * Careful, the result does not trim or fix errors in URL, like double slashes!
	 *
	 * @return path without base path
	 */
	function getPath(){
		return preg_replace('~\/?'.$this->basePath.'~i', '', $_SERVER['REQUEST_URI']);
	}

	/**
	 * Triggers a route with given parameters and methods.
	 * This method won't redirect to "otherwise" route, when route cannot be resolved!
	 *
	 * @param url the route to be triggered, containing get parameters
	 * @throws RouteUnresolvedException when the route cannot be resolved
	 * @return void
	 */
	function trigger($route, $methods = array(HttpMethod::GET)){
		$this->resolveWithoutRedirect($route, $methods);
	}

	private function resolveWithRedirect(){
		try{
			$this->resolveWithoutRedirect();
		}
		catch(\Exception $e){
			$this->resolveWithoutRedirect($this->redirect);
		}
	}

	private function resolveWithoutRedirect($url = null, array $methods = null){
		// get path from url
		$path = '';

		try{
			if(!$url){
				$path = $this->getPath();
			}
			else{
				$path = $url;
			}
		}
		catch(\Exception $e){
			throw new RoutePathException();
		}

		// set methods
		if(!$methods){
			$methods = array($_SERVER['REQUEST_METHOD']);
		}

		// resolve
		foreach($methods AS $method){
			$this->resolveUrl($path, $method);
		}
	}

	private function resolveUrl($route, $method){
		foreach($this->routes AS $value){
			if($value->matches($route) && in_array($method, $value->getRequestMethods())){
				switch($method){
					case HttpMethod::GET:
						$value->getController()->resolveGET($value->getParams());
						break;
					case HttpMethod::POST:
						$value->getController()->resolvePOST($value->getParams());
						break;
					case HttpMethod::PUT:
						$value->getController()->resolvePUT($value->getParams());
						break;
					case HttpMethod::DELETE:
						$value->getController()->resolveDELETE($value->getParams());
						break;
					case HttpMethod::HEAD:
						$value->getController()->resolveHEAD($value->getParams());
						break;
					case HttpMethod::TRACE:
						$value->getController()->resolveTRACE($value->getParams());
						break;
					case HttpMethod::CONNECT:
						$value->getController()->resolveCONNECT($value->getParams());
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
	 * @throws RoutePathException, RouteUnresolvedException
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

