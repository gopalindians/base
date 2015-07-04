<?php
class AboutController extends flimsy\Controller{
    function __construct($view){
        flimsy\Controller::__construct($view);
    }

    function exec(array $get, $method){
        $this->view->display();
    }
}
?>
