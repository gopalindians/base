<?php

namespace base;

class TestSuite{
	private $cases = array();

	function addCases(array $cases){
		array_merge($this->cases, $cases);
	}

	function getCases(){
		return $this->cases;
	}
}
?>
