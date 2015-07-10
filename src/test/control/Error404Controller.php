<?php
class Error404Controller extends base\Controller{
    function __construct(){
        base\Controller::__construct();
    }

    function exec(array $get, $method){
        print '<h1>#404</h1>';
    }
}
?>
