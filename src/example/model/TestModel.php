<?php
class TestModel extends base\Model{
	const NAME = 'TestModel';

	public $a;
	public $b;

	function __construct(){
		base\Model::__construct(TestModel::NAME);
	}

	static function jsonDeserialize($post){
		if(($data = base\Model::checkJsonObject($post, TestModel::NAME)) == null){
			return null;
		}

		$obj = new TestModel();
		base\Model::set($obj, 'a', $data);
		base\Model::set($obj, 'b', $data);

		return $obj;
	}

	function getData(){
		return array('a' => $this->a, 'b' => $this->b);
	}
}
?>
