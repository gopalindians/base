<?php

namespace base;

class TestRunner{
	const TEST_CASE_NAME = 'Running %s.<br />';
	const TEST_CASE_ERROR = 'Test case not found %s.';
	const TEST_SUCCESS = '<div style="background:#c3ffbb;padding:5px;">%s passed!</div>';
	const TEST_FAILURE = '<div style="background:#ffbbbb;padding:5px;">%s failed:<br /><pre>%s</pre></div>';
	const TEST_SUCCEDED = '<div style="background:#c3ffbb;padding:5px;">Result: %s tests passed!</div>';
	const TEST_FAILED = '<div style="background:#ffbbbb;padding:5px;">Result: %s of %s failed!</div>';
	const SEPERATOR = '<hr />';

	private $tests = 0;
	private $succeded = 0;
	private $failed = 0;

	function runTestCase($case){
		$test = $this->createTest($case);

		if(!$test){
			return;
		}

		$this->seperator();

		if(!$this->prepare($test)){
			return;
		}

		$this->seperator();
		$this->runTests($test);
		$this->report();
	}

	private function createTest($case){
		try{
			$test = new $case;

			if(!empty($test->getName())){
				print sprintf(self::TEST_CASE_NAME, $test->getName());
			}
			else{
				print sprintf(self::TEST_CASE_NAME, $case);
			}
		}
		catch(\Exception $e){
			print sprintf(self::TEST_CASE_ERROR, $case);
			return null;
		}

		return $test;
	}

	private function prepare(TestCase &$test){
		try{
			$test->prepare();
			$this->success('prepare');
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
					$test->setup();
					$test->$method();
					$this->success($method);
				}
				catch(\Exception $e){
					$this->failure($method, $e);
				}

				$this->seperator();
			}
		}
	}

	function runTestSuite($suite){

	}

	private function success($method){
		$this->succeded++;
		print sprintf(self::TEST_SUCCESS, $method);
	}

	private function failure($method, \Exception $e){
		$this->failed++;
		print sprintf(self::TEST_FAILURE, $method, htmlentities($e->getMessage()));
	}

	private function report(){
		if($this->failed){
			print sprintf(self::TEST_FAILED, $this->failed, $this->succeded);
			return;
		}
		
		print sprintf(self::TEST_SUCCEDED, $this->succeded);
	}

	private function seperator(){
		print self::SEPERATOR;
	}
}
?>
