<?php
class FormController extends base\Controller{
    function __construct(array $params = array()){
        base\Controller::__construct($params);
    }

    function resolvePOST(array $get){
        var_dump($_POST);
    }
}
?>
