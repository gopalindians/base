<?php
class HomeView extends base\View{
    private $welcome = '';
    private $nr = null;
    private $var = '';

    function __construct(array $params){
        $this->var = $params['some_var'];
    }

    function display(){
        print '<!DOCTYPE html><html><head><base href="/base/src/test/" />';
        print '<script src="../base/base.js"></script>';
        print '<script src="model/TestModel.js"></script>';
        print '<script src="control/HomeController.js"></script>';
        print '<link rel="stylesheet" type="text/css" href="view/layout.css" />';
        print '</head><body>';
        print '<h1>Home</h1>';
        print '<a href="./">Home</a> <a href="about">About</a><br /><br />';
        
        if($this->welcome){
            print 'Welcome '.$this->welcome.'!<br />';
        }

        if($this->nr){
            print 'Nr is: '.$this->nr;
        }

        print '<form action="./form" method="post"><input type="submit" value="post"></form>';
        print $this->var;
        print '</body></html>';
    }

    function setWelcome($welcome){
        $this->welcome = $welcome;
    }

    function setNr($nr){
        $this->nr = $nr;
    }
}
?>
