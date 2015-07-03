<?php
class Test extends Model{
	const NAME = 'Test';

	public $a;
	public $b;

	function __construct(){
		Model::__construct(Test::NAME);
	}

	static function jsonDeserialize($json){
		if(!Model::checkJsonObject($json, Test::NAME)){
			return null;
		}

		$obj = new Test();
		Model::set($obj, 'a', $json);
		Model::set($obj, 'b', $json);

		return $obj;
	}

	function jsonSerialize(){
		return $this->jsonSerializeToSchema(array('a' => $this->a,
					 							  'b' => $this->b));
	}
}
?>
