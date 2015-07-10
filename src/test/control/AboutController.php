<?php
class AboutController extends base\Controller{
    function __construct($view){
        base\Controller::__construct($view);
    }

    function resolveGET(array $get, $method){
        $this->view->display();
    }
}
?>
