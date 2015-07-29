<?php

namespace base;

abstract class TestCase{
	private $name;

	function __construct($name = ''){
		$this->name;
	}

	abstract function prepare();
	abstract function setup();

	function getName(){
		return $this->name;
	}
}
?>
