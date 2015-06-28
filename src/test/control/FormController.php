<?php
class FormController extends Controller{
    function __construct(){
        Controller::__construct();
    }

    function exec(array $get){
        var_dump($_POST);
    }
}
?>
