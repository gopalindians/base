<?php

namespace base;

class NavigationNode{
	private $id;
	private $when;
	private $get;
	private $post;
	private $controller;
	private $controllerParams;
	private $view;
	private $viewParams;
	private $sort;
	private $title;
	private $children;

	function __construct(Database $db, $id){
		// TODO: select

		$this->readChildren();
	}

	private function readChildren(){

	}

	// TODO: getter/setter, ...
}
?>
