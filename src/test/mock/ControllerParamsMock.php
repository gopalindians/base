<?php
class ControllerParamsMock extends base\Controller{
	public $params;

	function __construct(array $params){
        base\Controller::__construct($params, null);

        $this->params = $params;
    }
}
?>
