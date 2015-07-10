<?php

namespace base;

/**
 * MVC controller class. Controls your application server side.
 *
 * @author Marvin Blum
 */
abstract class Controller{
	protected $view = null;

	/**
	 * Constructor.
	 *
	 * @param view the View related to this controller.
	 */
	function __construct(array $params, $view = null){
		$this->view = $view;
	}

	/**
	 * Execute function, will be executed by Router on GET requests.
	 *
	 * @param get contains the GET parameters
	 * @param method the used method to access the route
	 * @return void
	 */
	function resolveGET(array $get){
		
	}

	/**
	 * @see resolveGET(array $get)
	 */
	function resolvePOST(array $get){
		
	}

	/**
	 * @see resolveGET(array $get)
	 */
	function resolvePUT(array $get){

	}

	/**
	 * @see resolveGET(array $get)
	 */
	function resolveDELETE(array $get){

	}

	/**
	 * @see resolveGET(array $get)
	 */
	function resolveHEAD(array $get){

	}

	/**
	 * @see resolveGET(array $get)
	 */
	function resolveTRACE(array $get){

	}

	/**
	 * @see resolveGET(array $get)
	 */
	function resolveCONNECT(array $get){

	}

	/**
	 * Resets the controller and _all_ environment variables.
	 *
	 * @return void
	 */
	protected function reset(){
		unset($_GET);
		unset($_POST);
		unset($_SESSION);
	}

	/**
	 * Resets _all_ GET environment variables.
	 *
	 * @return void
	 */
	protected function resetGET(){
		unset($_GET);
	}

	/**
	 * Resets _all_ POST environment variables.
	 *
	 * @return void
	 */
	protected function resetPOST(){
		unset($_POST);
	}

	/**
	 * Resets _all_ SESSION environment variables.
	 *
	 * @return void
	 */
	protected function resetSESSION(){
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
