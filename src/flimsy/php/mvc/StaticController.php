<?php
/**
 * Basic controller that just displays a view.
 */
class StaticController extends Controller{
	function __construct($view){
		Controller::__construct($view);
	}

	function exec(array $get, $method){
		$this->view->display();
	}
}
?>
