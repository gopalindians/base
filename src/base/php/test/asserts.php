<?php

namespace base;

/**
 * Checks that an condition is true.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param condition the condition to be checked
 * @return void
 */
function assertTrue($message, $condition){
	if(!$condition){
		throw new \Exception($message);
	}
}

/**
 * Checks that an condition is false.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param condition the condition to be checked
 * @return void
 */
function assertFalse($message, $condition){
	if($condition){
		throw new \Exception($message);
	}
}

/**
 * Checks that a value is null.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param condition the condition to be checked
 * @return void
 */
function assertNull($message, $condition){
	if($condition != null){
		throw new \Exception($message);
	}
}

/**
 * Checks that a value is not null.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param condition the condition to be checked
 * @return void
 */
function assertNotNull($message, $condition){
	if($condition == null){
		throw new \Exception($message);
	}
}

/**
 * Checks that two values are equal.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param a first value
 * @param b second value
 * @return void
 */
function assertEqual($message, $a, $b){
	if($a != $b){
		throw new \Exception($message);
	}
}

/**
 * Check that two values are not equal.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param a first value
 * @param b second value
 * @return void
 */
function assertNotEqual($message, $a, $b){
	if($a == $b){
		throw new \Exception($message);
	}
}

/**
 * Checks that a value is not empty.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param condition the condition to be checked
 * @return void
 */
function assertEmpty($message, $condition){
	if(!empty($condition)){
		throw new \Exception($message);
	}
}

/**
 * Checks that a value is empty.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param condition the condition to be checked
 * @return void
 */
function assertNotEmpty($message, $condition){
	if(empty($condition)){
		throw new \Exception($message);
	}
}

/**
 * Checks that an array or string contains a value.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param search the object to search in
 * @param find the substring or key to find
 * @return void
 */
function assertContains($message, $search, $find){
	if(is_array($search)){
		if(!isset($search[$find])){
			throw new \Exception($message);
		}
	}
	else{
		if(strpos($search, $find) === false){
			throw new \Exception($message);
		}
	}
}

/**
 * Checks that an array or string does not contain a value.
 * Throws an exception on failure.
 *
 * @param message the message to print on failure
 * @param search the object to search in
 * @param find the substring or key to find
 * @return void
 */
function assertNotContains($message, $search, $find){
	if(is_array($search)){
		if(isset($search[$find])){
			throw new \Exception($message);
		}
	}
	else{
		if(strpos($search, $find) !== false){
			throw new \Exception($message);
		}
	}
}
?>
