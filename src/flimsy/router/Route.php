<?php

class Route{
	private $route;

	function __construct($route = ''){
		$this->route = $route;
	}

	function getRoute(){
		return $this->route;
	}
}
?>
