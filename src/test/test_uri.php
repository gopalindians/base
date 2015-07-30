<?php

namespace base;

class TestURI extends TestCase{
	function __construct(){
		parent::__construct('URI test');
	}

	function prepare(){
		
	}

	function setup(){
		
	}

	function cleanup(){
		
	}

	function testParsing(){
		$a = new URI('////this///is//////a///route//');
		$b = new URI('/this///is/a/route/:a///:b?///:c?/');

		assertContains('Must contain "this".', $a->getRouteParts(), 'this');
		assertContains('Must contain "route".', $a->getRouteParts(), 'route');
	}

	function testComparing(){
		$a = new URI('/they/are');
		$b = new URI('/not/equal');

		assertFalse('Routes must not be equal 1.', $a->equals($b));

		$c = new URI('/these/are');
		$d = new URI('/these/are');

		assertTrue('Routes must be equal 2.', $c->equals($d));

		$e = new URI('/these/are/:not');
		$f = new URI('/these/are/:not/:equal?');

		assertFalse('Routes must not be equal 3.', $e->equals($f, true));

		$g = new URI('/these/are/:with/:params?');
		$h = new URI('/these/are/:with/:params?');

		assertTrue('Routes must be equal 4.', $g->equals($h, true));
	}
}
?>
