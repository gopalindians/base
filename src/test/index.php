<?php
define('BASE_ROOT', '../base');
require_once '../base/base.php';

require_once 'test_email.php';
require_once 'test_formvalidator.php';
require_once 'test_mysql.php';
require_once 'test_navigation.php';
require_once 'test_pdo.php';
require_once 'test_router.php';
require_once 'test_uri.php';

class AllTests extends base\TestSuite{
	const NAME = 'AllTests';

	function __construct(){
		parent::__construct(self::NAME);

		$this->addCases(array('base\EmailTest',
							  'base\FormValidatorTest',
							  'base\MySQLTest',
							  'base\NavigationTest',
							  'base\PDOTest',
							  'base\TestRouter',
							  'base\TestURI'));
	}
}

$runner = new base\TestRunner();
$runner->runTestSuite('AllTests');
?>
