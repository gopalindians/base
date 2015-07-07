<?php

namespace flimsy;

/**
 * Basic controller that displays a single view.
 *
 * @author Marvin Blum
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
