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
		base\assertTrue('should be true', false);
	}

	function testB(){
		base\assertFalse('assert message', true);
	}

	function testC(){
		base\assertContains('string must contain substring', 'Hello World!', 'World');
	}

	function testD(){
		base\assertNotContains('string must contain substring', 'Hello World!', 'World');
	}

	function testE(){
		base\assertContains('array must contain element', array('a' => 1, 'b' => 2), 'b');
	}

	function testF(){
		base\assertContains('array must contain element', array('a' => 1, 'b' => 2), 'c');
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
?>
