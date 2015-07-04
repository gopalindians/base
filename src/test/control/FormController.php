<?php
class FormController extends flimsy\Controller{
    function __construct(){
        flimsy\Controller::__construct();
    }

    function exec(array $get, $method){
        var_dump($_POST);
    }
}
?>
