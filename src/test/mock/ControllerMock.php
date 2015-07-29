<?php
class ControllerMock extends base\Controller{
	public $resolveGetCalled = false;
	public $resolvePostCalled = false;
	public $resolvePutCalled = false;
	public $resolveDeleteCalled = false;
	public $resolveTraceCalled = false;
	public $resolveHeadCalled = false;
	public $resolveConnectCalled = false;

	function __construct(){
        base\Controller::__construct(array(), null);
    }

    function resolveGET(array $get){
        $this->resolveGetCalled = true;
    }

    function resolvePOST(array $get){
        $this->resolvePostCalled = true;
    }

    function resolvePUT(array $get){
        $this->resolvePutCalled = true;
    }

    function resolveDELETE(array $get){
        $this->resolveDeleteCalled = true;
    }

    function resolveTRACE(array $get){
        $this->resolveTraceCalled = true;
    }

    function resolveHEAD(array $get){
        $this->resolveHeadCalled = true;
    }

    function resolveCONNECT(array $get){
        $this->resolveConnectCalled = true;
    }
}
?>
