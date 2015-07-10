<?php
class FormController extends base\Controller{
    function __construct(){
        base\Controller::__construct();
    }

    function resolvePOST(array $get){
        var_dump($_POST);
    }
}
?>
