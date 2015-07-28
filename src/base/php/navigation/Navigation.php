<?php

namespace base;

class Navigation{
	const CACHE = 'BASE_NAVIGATION_CACHE';
	const DB_TABLE = 'navigation';

	private $db;
	private $root;
	private $useCache = false;
	private $cached;

	function __construct(Database $db){

	}

	function enableCache(){

	}

	function disableCache(){

	}

	function clearCache(){

	}

	private function read(){
		
	}

	function getRoot(){

	}

	function findNode($attr, $value){

	}

	function getCurrentNode(Router $router){

	}
}
?>
