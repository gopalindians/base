<?php

namespace base;

/**
 * Basic controller that displays a single view,
 * no matter which HTTP method is used or parameters are passed.
 *
 * @author Marvin Blum
 */
class StaticController extends Controller{
	function __construct($view){
		Controller::__construct(array(), $view);
	}

	function resolveGET(array $get){
		$this->view->display();
	}

	function resolvePOST(array $get){
		$this->view->display();
	}

	function resolvePUT(array $get){
		$this->view->display();
	}

	function resolveDELETE(array $get){
		$this->view->display();
	}

	function resolveHEAD(array $get){
		$this->view->display();
	}

	function resolveTRACE(array $get){
		$this->view->display();
	}

	function resolveCONNECT(array $get){
		$this->view->display();
	}
}
?>
