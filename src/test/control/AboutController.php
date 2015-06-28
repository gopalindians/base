<?php
class AboutController extends Controller{
    function __construct($view){
        Controller::__construct($view);
    }

    function exec(array $get){
        $this->view->display();
    }
}
?>
