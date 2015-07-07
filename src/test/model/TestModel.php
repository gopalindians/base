<?php
class TestModel extends flimsy\Model{
	const NAME = 'TestModel';

	public $a;
	public $b;

	function __construct(){
		flimsy\Model::__construct(TestModel::NAME);
	}

	static function jsonDeserialize($post){
		if(($data = flimsy\Model::checkJsonObject($post, TestModel::NAME)) == null){
			return null;
		}

		$obj = new TestModel();
		flimsy\Model::set($obj, 'a', $data);
		flimsy\Model::set($obj, 'b', $data);

		return $obj;
	}

	function getData(){
		return array('a' => $this->a, 'b' => $this->b);
	}
}
?>
