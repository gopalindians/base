<?php

namespace base;

/**
 * Class to work with RESTful URIs.
 *
 * @author Marvin Blum
 */
class URI{
	const DELIMETER = '/';
	const PARAM_DELIMETER = '/:';
	const PARAM_OPTIONAL = '?';

	private $route = array();
	private $params = array();
	private $optionalParams = array();

	function __construct($route = null){
		if($route){
			$this->parse($route);
		}
	}

	private function parseRoute($route){
		$parts = explode(self::DELIMETER, $route);

		foreach($parts AS $value){
			if(!empty($value)){
				$this->route[] = $value;
			}
		}
	}

	private function parseParams($route){
		$get = explode(self::PARAM_DELIMETER, $route);

		foreach($get AS $value){
			if(!empty($value)){
				$value = str_replace('/', '', $value);

				if(substr($value, -1) == self::PARAM_OPTIONAL){
					$this->optionalParams[] = $value;
				}
				else{
					$this->params[] = $value;
				}
			}
		}
	}

	private function parse($route){
		$len = strlen($route);
		$end = strpos($route, self::PARAM_DELIMETER);

		if($end === FALSE){
			$end = strlen($route);
		}

		$this->parseRoute(substr($route, 0, $end));

		if($end != $len){
			$this->parseParams(substr($route, $end, $len));
		}
	}

	function equals(URI $uri, $compareParams = false){
		if(!$compareParams){
			$a = $this->route;
			$b = $uri->getRouteParts();
		}
		else{
			$a = $this->getFullRouteParts();
			$b = $uri->getFullRouteParts();
		}

		if(count($a) != count($b)){
			return false;
		}

		foreach($a AS $key => $value){

			if($value != $b[$key]){
				return false;
			}
		}

		return true;
	}

	function getFullRouteParts(){
		return array_merge($this->route, $this->getParams());
	}

	function getFullRoute(){
		return $this->getRoute().self::DELIMETER.$this->getRouteParams();
	}

	function getRoute(){
		return self::DELIMETER.implode(self::DELIMETER, $this->route);
	}

	function getRouteParts(){
		return $this->route;
	}

	function getRouteParams(){
		return implode(self::DELIMETER, $this->getParams());
	}

	function getParams(){
		return array_merge($this->params, $this->optionalParams);
	}

	function getRequiredParams(){
		return $this->params;
	}

	function getOptionalParams(){
		return $this->optionalParams;
	}
}
?>
