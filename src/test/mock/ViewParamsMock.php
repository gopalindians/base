<?php
class ViewParamsMock extends base\View{
	public $params; // does not work, since this is a child class of View...

	function __construct(array $params){
		$this->params = $params;
	}

	function display(){

	}
}
?>
