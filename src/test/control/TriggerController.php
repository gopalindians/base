<?php
class TriggerController extends base\Controller{
	function __construct(array $param = array()){
		base\Controller::__construct($param);
	}

    function resolveGET(array $get){
        print 'trigger resolved by GET';
    }
}
?>
