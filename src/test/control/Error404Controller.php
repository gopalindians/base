<?php
class Error404Controller extends base\Controller{
    function __construct(array $params = array()){
        base\Controller::__construct($params);
    }

    function resolveGET(array $get){
        print '<h1>#404</h1>';
    }
}
?>
