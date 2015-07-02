<?php
class HomeView extends View{
    private $welcome = '';
    private $nr = null;

    function __construct(){
        
    }

    function display(){
        print '<!DOCTYPE html><html><head><base href="/flimsy/src/test/" /><link rel="stylesheet" type="text/css" href="view/layout.css" /></head><body>';
        print '<h1>Home</h1>';
        print '<a href="./">Home</a> <a href="about">About</a><br /><br />';
        
        if($this->welcome){
            print 'Welcome '.$this->welcome.'!<br />';
        }

        if($this->nr){
            print 'Nr is: '.$this->nr;
        }

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
