<?php
define('BASE_ROOT', '../base');
require_once '../base/base.php';

class aTestCase extends base\TestCase{
	const NAME = 'aTestCase';

	function __construct(){
		parent::__construct(self::NAME);
	}

	function prepare(){
		
	}

	function setup(){
		
	}

	function testA(){
		
	}

	function testB(){
		
	}

	function testException(){
		throw new Exception('This is an exception');
	}
}

class aTestSuite extends base\TestSuite{
	const NAME = 'My test suite';

	function __construct(){
		parent::__construct(self::NAME);

		$this->addCases(array('aTestCase'));
	}
}

$runner = new base\TestRunner();
$runner->runTestSuite('aTestSuite');
$runner->report();
?>
