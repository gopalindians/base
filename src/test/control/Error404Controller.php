<?php
class Error404Controller extends Controller{
    function __construct(){
        Controller::__construct();
    }

    function exec(array $get){
        print '<h1>#404</h1>';
    }
}
?>
