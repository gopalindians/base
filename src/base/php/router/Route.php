<?php

namespace base;

/**
 * Class to define a route on your page. Used in Router.
 *
 * @author Marvin Blum
 */
class Route{
	private $route;
	private $requestMethods;
	private $controller;

	private $params = array();
	private $optionalParams = 0;

	/**
 	 * Constructor.
	 *
 	 * @param route route to resolve realtive to base path
 	 *		  contains the REST URL, e.g. /home and GET parameters, e.g. /:param0/:param1
 	 *		  use ? after a GET parameter to make it optional, e.g. /:param0/:param1?
 	 * 		  where only last parameters can be optional, this won't be resolved correctly: /:param0?/:param1
 	 * @param requestMethods allowed request methods as an array, can be one of the following (strings): GET, POST, PUT, DELETE
 	 * @param controller controller for this route
	 */
	function __construct($route, array $requestMethods, Controller $controller){
		$this->route = new URI($route);
		$this->requestMethods = $requestMethods;
		$this->controller = $controller;
	}

	private function resolveRoute(URI $route, $setOptionalParams = false){
		/*$route = preg_replace('~/+~', '/', rtrim('/'.$route, '/'));
		$routeEnd = strpos($route, self::PARAM_DELIMITER);

		if($routeEnd === FALSE){
			return array($route, array());
		}

		$get = explode(self::PARAM_DELIMITER, substr($route, $routeEnd, strlen($route)));

		foreach($get AS $key => $value){
			// remove empty
			if(empty($value)){
				unset($get[$key]);
				continue;
			}

			// test optional
			if(substr($value, -1) == self::PARAM_OPTIONAL){
				if($setOptionalParams){
					$this->optionalParams++;
				}

				$get[$key] = substr($value, 0, -1);
			}
		}

		return array(substr($route, 0, $routeEnd), $get);*/
	}

	/**
	 * Tests if this route matches the current URL.
	 *
	 * @param route route to test
	 */
	function matches(URI $route){
		//$routeParse = $this->resolveRoute($route); // make sure there is a slash in front
		//$accept = $this->route == $routeParse[0];

		//if($accept && count($routeParse[1]) >= count($this->routeParams)-$this->optionalParams && count($routeParse[1]) <= count($this->routeParams)){
		if($this->route->equals($route)){
			// set GET variables
			/*foreach($routeParse[1] AS $key => $value){
				$this->params[$this->routeParams[$key]] = urldecode($value);
			}*/

			return true;
		}

		return false;
	}

	/**
	 * @return URL which this route resolves
	 */
	function getRoute(){
		return $this->route;
	}

	/**
	 * @return allowed request methods as an array
	 */
	function getRequestMethods(){
		return $this->requestMethods;
	}

	/**
	 * @return controller of this route
	 */
	function getController(){
		return $this->controller;
	}

	/**
	 * @return GET params of this route
	 */
	function getParams(){
		return $this->params;
	}
}
?>
