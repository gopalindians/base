<?php
class ViewResolveMock extends base\View{
	public $out;

	function __construct($out){
		$this->out = $out;
	}

	function display(){
		base\assertFail($this->out);
	}
}
?>
