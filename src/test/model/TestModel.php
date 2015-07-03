<?php
class TestModel extends Model{
	const NAME = 'TestModel';

	public $a;
	public $b;

	function __construct(){
		Model::__construct(TestModel::NAME);
	}

	static function jsonDeserialize($json){
		if(!Model::checkJsonObject($json, TestModel::NAME)){
			return null;
		}

		$obj = new TestModel();
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
