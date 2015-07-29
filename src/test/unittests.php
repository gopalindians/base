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

$runner = new base\TestRunner();
$runner->runTestCase('aTestCase');
?>
