<?php
class HomeView extends flimsy\View{
    private $welcome = '';
    private $nr = null;

    function display(){
        print '<!DOCTYPE html><html><head><base href="/flimsy/src/test/" />';
        print '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>';
        print '<script src="../flimsy/js/util/namespace.js"></script>';
        print '<script src="../flimsy/js/util/extend.js"></script>';
        print '<script src="../flimsy/js/mvc/Model.js"></script>';
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
