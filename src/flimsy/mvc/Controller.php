<?php

abstract class Controller{
	protected $view = null;
	protected $get = null;
	protected $post = null;
	protected $session = null;

	function __construct($view){
		$this->view = $view;

		if(count($_GET)){
			$this->get = $_GET;
		}

		if(count($_POST)){
			$this->get = $_POST;
		}

		if(count($_SESSION)){
			$this->session = $_SESSION;
		}
	}

	abstract function exec();

	protected function reset(){
		unset($_GET);
		unset($_POST);
		unset($_SESSION);

		$this->get = null;
		$this->post = null;
		$this->session = null;
	}

	function getView(){
		return $this->view;
	}
}
?>
