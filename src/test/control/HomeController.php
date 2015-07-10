<?php
class HomeController extends base\Controller{
    private $defaultWelcome = 'You';

    function __construct(array $params, $view){
        base\Controller::__construct($params, $view);

        if(isset($params['welcome'])){
            $this->defaultWelcome = $params['welcome'];
        }
    }

    function resolveGET(array $get){
    	if(isset($get['welcome'])){
    		$this->view->setWelcome($get['welcome']);
    	}
        else{
            $this->view->setWelcome($this->defaultWelcome);
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
