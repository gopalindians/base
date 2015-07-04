<?php
class TestModel extends Model{
	const NAME = 'TestModel';

	public $a;
	public $b;

	function __construct(){
		Model::__construct(TestModel::NAME);
	}

	static function jsonDeserialize($post){
		if(($data = Model::checkJsonObject($post, TestModel::NAME)) == null){
			return null;
		}

		$obj = new TestModel();
		Model::set($obj, 'a', $data);
		Model::set($obj, 'b', $data);

		return $obj;
	}

	function jsonSerialize(){
		return $this->jsonSerializeToSchema(array('a' => $this->a,
					 							  'b' => $this->b));
	}
}
?>
