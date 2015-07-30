<?php
class ViewParamsMock extends base\View{
	public $params;

	function __construct(array $params){
		$this->params = $params;
	}

	function display(){

	}
}
?>
