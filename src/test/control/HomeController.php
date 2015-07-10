<?php
class HomeController extends base\Controller{
    function __construct(HomeView $view){
        base\Controller::__construct($view);
    }

    function resolveGET(array $get){
    	if(isset($get['welcome'])){
    		$this->view->setWelcome($get['welcome']);
    	}

    	if(isset($get['nr'])){
    		$this->view->setNr($get['nr']);
    	}

        $this->view->display();     
    }

    function resolvePOST(array $get){
        $test = TestModel::jsonDeserialize($_POST);
        
        if($test){
            $test->a = 123;
            $test->b = 456;
            print $test->jsonSerialize();
        }
    }
}
?>
