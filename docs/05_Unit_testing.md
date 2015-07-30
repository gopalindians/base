# Unit testing

base provides an easy way to implement unit tests. The tests can be run on server, so that the result will be shown in browser. No external tools are required.

## Write test cases

To create a test case, extend the *TestCase* base class. You can set a name to identify the test case. Overwrite *prepare()*, *setup()* and *cleanup()*. *prepare()* is called once, when the test case is started. *setup()* will be called before each test method. And *cleanup()* is called after all tests.

A test method must start with *test...*, does not accept parameters and shouldn't return. To test your conditions, use assert functions provided by base.

**Example:**

```PHP
class ATestCase extends base\TestCase{
    const NAME = 'ATestCase';

    function __construct(){
        parent::__construct(self::NAME); // pass optinal name
    }

    function prepare(){
        // called once
    }

    function setup(){
        // called before each test method
    }

    function cleanup(){
        // called after all tests have been executed
    }

    // a test method
    function testA(){
        base\assertTrue('should be true', false); // assert
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

    // if an exception is thrown, the test will fail (printed red)
    function testException(){
        throw new Exception('This is an exception');
    }
}
```

## Running test cases

The *TestRunner* is required to run test cases. It makes sure that exceptions are catched and propperly printed. It also collects data for a report and prints results.

**Example:**

```PHP
$runner = new base\TestRunner();
$runner->runTestCase('ATestCase'); // run a single test case
$runner->runTestSuite('ATestSuite'); // run a test suite
$runner->report(); // prints report, also called by runTestSuite()
```

## Test suites

To simplify running multiple test cases, a test suite can be used to merge them. You can then pass the suites classname to *runTestSuite()* of *TestRunner*.

**Example:**

```PHP
class ATestSuite extends base\TestSuite{
    const NAME = 'My test suite';

    function __construct(){
        parent::__construct(self::NAME);

        $this->addCases(array('aTestCase')); // add as much test cases as you like
    }
}
```

Test cases are added using *addCases()*, which takes an array and adds them to the suite. If running a suite, the suites name will be printed before test cases.

## Asserts

Here is a list of all available asserts, the first parameter is always a string, shown on failure (not in the list):

| Assert | Parameters |
| ------ | ---------- |
| assertTrue | condition(bool) |
| assertFalse | condition(bool) |
| assertNull | condition(object, value) |
| assertNotNull | condition(object, value) |
| assertEqual | a(object, string, value), b(object, string, value) |
| assertNotEqual | a(object, string, value), b(object, string, value) |
| assertEmpty | condition(array, string) |
| assertNotEmpty | condition(array, string) |
| assertContains | search(array, string), find(index, string) |
| assertNotContains | search(array, string), find(index, string) |
