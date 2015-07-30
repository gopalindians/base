<?php

namespace base;

/**
 * Class used to run unit tests in base.
 * It provides two ways to run tests:
 *
 * 1. run a single test case using runTestCase(TestCase)
 * 2. run multiple test cases using a suite runTestSuite(TestSuite)
 *
 * @author Marvin Blum
 */
class TestRunner{
	const GREEN = '<div style="background:#c3ffbb;padding:5px;margin:0 0 5px 0;">';
	const RED = '<div style="background:#ffbbbb;padding:5px;margin:0 0 5px 0;">';
	const GREY = '<div style="background:#e1e1e1;padding:5px;margin:0 0 5px 0;">';
	const END = '</div>';

	const TEST_CASE_NAME = self::GREY.'Running: <b>%s</b>'.self::END;
	const TEST_SUITE_NAME = self::GREY.'Running suite: <b>%s</b>'.self::END;
	const TEST_CASE_ERROR = self::RED.'Test case not found <b>%s</b>.'.self::END;
	const TEST_SUITE_ERROR = self::RED.'Test suite not found <b>%s</b>.'.self::END;
	const TEST_SUCCESS = self::GREEN.'<b>%s</b> passed!'.self::END;
	const TEST_FAILURE = self::RED.'<b>%s</b> failed:<br /><pre>%s</pre>'.self::END;
	const TEST_SUCCEDED = self::GREEN.'=&gt; Result: <b>%s</b> tests passed!'.self::END;
	const TEST_FAILED = self::RED.'=&gt; Result: <b>%s</b> of <b>%s</b> tests failed!'.self::END;

	private $tests = 0;
	private $succeded = 0;
	private $failed = 0;

	/**
	 * Runs a single test case and prints result.
	 *
	 * @param case the test case classname, the class must extend base\TestCase
	 * @return void
	 */
	function runTestCase($case){
		$test = $this->createTest($case);

		if(!$test || !$this->prepare($test)){
			return;
		}

		$this->runTests($test);

		try{
			$test->cleanup();
		}
		catch(\Exception $e){
			$this->failure('cleanup', $e);
		}
	}

	private function createTest($case){
		if(!class_exists($case)){
			print sprintf(self::TEST_CASE_ERROR, $case);
			return null;
		}

		$test = new $case;

		if(!empty($test->getName())){
			print sprintf(self::TEST_CASE_NAME, $test->getName());
		}
		else{
			print sprintf(self::TEST_CASE_NAME, $case);
		}

		return $test;
	}

	private function prepare(TestCase &$test){
		try{
			$test->prepare();
		}
		catch(\Exception $e){
			$this->failure('prepare', $e);
			return false;
		}

		return true;
	}

	private function runTests(TestCase &$test){
		foreach(get_class_methods($test) AS $method){
			if(strtolower(substr($method, 0, 4)) == 'test'){
				try{
					$this->tests++;
					$test->setup();
					$test->$method();
					$this->success($method);
				}
				catch(\Exception $e){
					$this->failure($method, $e);
				}
			}
		}
	}

	/**
	 * Runs a test suite.
	 * A report will be printed afterwards.
	 *
	 * @param suite the classname of suite to run, must be of type base\TestSuite
	 * @return void
	 */
	function runTestSuite($suite){
		$test = $this->createTestSuite($suite);

		if(!$test){
			return;
		}

		foreach($test->getCases() AS $case){
			$this->runTestCase($case);
		}

		$this->report();
	}

	private function createTestSuite($suite){
		if(!class_exists($suite)){
			print sprintf(self::TEST_SUITE_ERROR, $suite);
			return null;
		}

		$test = new $suite;

		if(!empty($test->getName())){
			print sprintf(self::TEST_SUITE_NAME, $test->getName());
		}
		else{
			print sprintf(self::TEST_SUITE_NAME, $suite);
		}

		return $test;
	}

	private function success($method){
		$this->succeded++;
		print sprintf(self::TEST_SUCCESS, $method);
	}

	private function failure($method, \Exception $e){
		$this->failed++;
		print sprintf(self::TEST_FAILURE, $method, htmlentities($e->getMessage()));
	}

	/**
	 * Prints test result report.
	 * The report contains how many tests were run and how many of them failed.
	 *
	 * @return void
	 */
	function report(){
		if($this->failed){
			print sprintf(self::TEST_FAILED, $this->failed, $this->tests);
		}
		else{
			print sprintf(self::TEST_SUCCEDED, $this->succeded);
		}

		$this->tests = 0;
		$this->succeded = 0;
		$this->failed = 0;
	}
}
?>
