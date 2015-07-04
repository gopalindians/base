<?php
class HomeController extends flimsy\Controller{
    function __construct(HomeView $view){
        flimsy\Controller::__construct($view);
    }

    function exec(array $get, $method){
        if($method == 'GET'){
        	if(isset($get['welcome'])){
        		$this->view->setWelcome($get['welcome']);
        	}

        	if(isset($get['nr'])){
        		$this->view->setNr($get['nr']);
        	}

            $this->view->display();
        }
        else{
            $test = TestModel::jsonDeserialize($_POST);
            
            if($test){
                $test->a = 123;
                $test->b = 456;
                print $test->jsonSerialize();
            }
        }
    }
}
?>
