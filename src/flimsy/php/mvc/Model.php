<?php
abstract class Model{
	protected $classname;

	/**
	 * Constructor.
	 *
	 * @param classname pass the name of implementing class to serialize/deserialize,
	 *		  should be unique, default is "Model"
	 */
	function __construct($classname = 'Model'){
		$this->classname = $classname;
	}

	/**
	 * Tries to map the passed json object to this class and returns a new instance.
	 * The json must be build in the schema:
	 *
	 * {class:"Classname", data:{DATA}}
	 *
	 * "class" is required to identify the object, "data" is the use data.
	 *
	 * @param json a json object (not a string! use json_decode())
	 * @return a new instance of this class, or null if not possible
	 */
	static abstract function jsonDeserialize($json);

	/**
	 * Tests if the object passed to jsonDeserialize() maps to this object.
	 *
	 * @param json a json object (not a string! use json_decode())
	 * @param classname the classname of this class
	 * @return true, if the json objects maps to this object by its "class" member, false otherwise
	 */
	static protected function checkJsonObject($json, $classname){
		return is_object($json) && isset($json->class) && isset($json->data) && $classname == $json->class;
	}

	/**
	 * Tests if this objects has passed member and sets value from json object data.
	 *
	 * @param obj pass this object, it's required to set members of derived classes
	 * @param var the member name as a string
	 * @param json a json object (not a string! use json_decode())
	 * @return void
	 */
	static function set($obj, $var, $json){
		if(property_exists($obj, $var) && property_exists($json->data, $var)){
			$obj->$var = $json->data->$var;
		}
	}

	/**
	 * Returns a serialized json object of this class.
	 *
	 * @return a serialized json object (string) of this class
	 */
	abstract function jsonSerialize();

	/**
	 * Serializes this object to schema and adds passed data.
	 * Should be used in jsonSerialize() to simplify communication to JavaScript.
	 *
	 * @param data will be added to the json object using json_encode()
	 * @return the json object
	 */
	protected function jsonSerializeToSchema($data){
		return '{"class":"'.$this->classname.'","data":'.json_encode($data).'}';
	}
}
?>
