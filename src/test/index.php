<?php
define('BASE_ROOT', '../base');
require_once '../base/base.php';

class AllTests extends base\TestSuite{
	const NAME = 'AllTests';

	function __construct(){
		parent::__construct(self::NAME);

		$this->addCases(array());
	}
}

$runner = new base\TestRunner();
$runner->runTestSuite('AllTests');
?>
