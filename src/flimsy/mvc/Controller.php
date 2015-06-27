<?php
abstract class Controller{
	protected $view = null;

	/**
	 * Constructor.
	 *
	 * @param view The View related to this controller.
	 */
	function __construct($view = null){
		$this->view = $view;
	}

	/**
	 * Execute function, will be executed by Router.
	 *
	 * @return void
	 */
	abstract function exec(array $get);

	/**
	 * Resets the controller and environment variables.
	 *
	 * @return void
	 */
	protected function reset(){
		unset($_GET);
		unset($_POST);
		unset($_SESSION);
	}

	/**
	 * @return View related to this controller or null.
	 */
	function getView(){
		return $this->view;
	}
}
?>
