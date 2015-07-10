<?php
class FormController extends base\Controller{
    function __construct(){
        base\Controller::__construct();
    }

    function exec(array $get, $method){
        var_dump($_POST);
    }
}
?>
