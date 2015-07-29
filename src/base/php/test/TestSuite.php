<?php

namespace base;

/**
 * Base class for test suites.
 * Test suites are used to bundle multiple test cases.
 * To add cases, use addCases(array).
 *
 * @author Marvin Blum
 */
abstract class TestSuite{
	private $name;
	private $cases = array();

	/**
 	 * Creates a new test suite.
	 *
 	 * @param name optional name shown on test output
	 */
	function __construct($name = ''){
		$this->name = $name;
	}

	/**
	 * Adds cases to this suite.
	 *
	 * @param cases the test cases to add as strings within an array
	 * @return void
	 */
	function addCases(array $cases){
		$this->cases = array_merge($this->cases, $cases);
	}

	/**
	 * Returns all test cases as array of strings.
	 *
	 * @return all test cases as array of strings
	 */
	function getCases(){
		return $this->cases;
	}

	/**
	 * @return returns the name of this test suite
	 */
	function getName(){
		return $this->name;
	}
}
?>
