<?php
class Error404Controller extends flimsy\Controller{
    function __construct(){
        flimsy\Controller::__construct();
    }

    function exec(array $get, $method){
        print '<h1>#404</h1>';
    }
}
?>
