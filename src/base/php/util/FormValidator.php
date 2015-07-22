<?php

namespace base;

/**
 * Utility class to validate HTML forms.
 * Generally trims containing fields, but does not return SQL injection safe data.
 *
 * @author Marvin Blum
 */
class FormValidator{
	private $data;
	private $error = array();

	/**
	 * Constructor.
	 *
	 * @param data the data to check as an associative array
	 */
	function __construct($data){
		$this->data = $data;
	}

	/**
	 * Checks that no field is empty and stores empty fields in error results.
	 *
	 * @return true if no field was empty, else false
	 */
	function notEmpty(){
		$notempty = true;

		foreach($this->data AS $key => $value){
			if(empty(trim($value))){
				$this->error[$key] = $value;
				$notempty = false;
			}
		}

		return $notempty;
	}

	/**
	 * Checks if two fields are equal. If not, both will be added to error results.
	 *
	 * @param key0 key of the first field
	 * @param key1 key of the second field
	 * @return true if both fields are equal, else false
	 */
	function equal($key0, $key1){
		if(!isset($this->data[$key0]) || !isset($this->data[$key1])){
			return false;
		}

		$equal = true;

		if(trim($this->data[$key0]) != trim($this->data[$key1])){
			$this->error[$key0] = $this->data[$key0];
			$this->error[$key1] = $this->data[$key1];
			$equal = false;
		}

		return $equal;
	}

	/**
	 * Checks if the field is an email.
	 *
	 * @param key the key of the field
	 * @return true if the field could be validated as an email, else false
	 */
	function isEmail(string $key){
		if(!isset($this->data[$key])){
			return false;
		}

		return filter_var($this->data[$key], FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Returns all fields that failed validation.
	 *
	 * @return array of fields that failed validation
	 */
	function which(){
		return $this->error;
	}
}
?>
