<?php

abstract class View{
    protected $controller = null;
    protected $page = '';

    /*
     * @param controller
	 * @param path
     */
    function __construct(Controller $controller, $page){
        $this->controller = $controller;
        $this->page = $page;
    }

    abstract function display();
}
?>
