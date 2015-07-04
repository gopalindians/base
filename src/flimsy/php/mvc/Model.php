<?php namespace flimsy;
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
	 * Tries to map the passed $_POST to this class and returns a new instance.
	 * The array must be build in the schema:
	 *
	 * "Classname" => "JsonAsString"
	 *
	 * "Classname" is required to identify the object, "JsonAsString" is the use data.
	 *
	 * @param post the post data
	 * @return a new instance of this class, or null if not possible
	 */
	static abstract function jsonDeserialize($post);

	/**
	 * Tests if the post data passed to jsonDeserialize() maps to this object.
	 *
	 * @param post the post data
	 * @param classname the classname of this class
	 * @return the json objects if it maps, null otherwise
	 */
	static protected function checkJsonObject($post, $classname){
		if(!isset($post[$classname])){
			return null;
		}

		try{
			$obj = json_decode($post[$classname]);
		}
		catch(Exception $e){
			$obj = null;
		}

		return $obj;
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
		if(property_exists($obj, $var) && property_exists($json, $var)){
			$obj->$var = $json->$var;
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
