<?php

class Route{
	private $route;
	private $requestMethods;
	private $controller;

	function __construct($route, array $requestMethods, Controller $controller){
		$this->route = trim($route, '/');
		$this->requestMethods = $requestMethods;
		$this->controller = $controller;
	}

	function getRoute(){
		return $this->route;
	}

	function getRequestMethods(){
		return $this->requestMethods;
	}

	function getController(){
		return $this->controller;
	}
}
?>
