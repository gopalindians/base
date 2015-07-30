<?php

namespace base;

/**
 * Base class for test cases.
 * Extend to create a new test case and use in TestRunner.
 *
 * @author Marvin Blum
 */
abstract class TestCase{
	private $name;

	/**
 	 * Creates a new TestCase.
 	 *
 	 * @param name optional name shown on test output
	 */
	function __construct($name = ''){
		$this->name = $name;
	}

	abstract function prepare();
	abstract function setup();
	abstract function cleanup();

	/**
	 * @return the name of this test case
	 */
	function getName(){
		return $this->name;
	}
}
?>
