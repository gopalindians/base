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

        $test = Test::jsonDeserialize(json_decode('{"class":"Test", "data":{"a":321, "b":123}}'));
        var_dump($test);
        print '<br>';
        var_dump($test->jsonSerialize());

        $this->view->display();
    }
}
?>
