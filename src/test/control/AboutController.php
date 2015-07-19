<?php
class AboutController extends base\Controller{
    function __construct(array $params, $view){
        base\Controller::__construct($params, $view);
    }

    function resolveGET(array $get){
        $this->view->display();
    }
}
?>
