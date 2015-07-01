<?php
class HomeController extends Controller{
    function __construct(HomeView $view){
        Controller::__construct($view);
    }

    function exec(array $get, $method){
    	if(isset($get['welcome'])){
    		$this->view->setWelcome($get['welcome']);
    	}

    	if(isset($get['nr'])){
    		$this->view->setNr($get['nr']);
    	}

        $this->view->display();
    }
}
?>
