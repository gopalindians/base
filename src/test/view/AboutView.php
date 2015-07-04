<?php
class AboutView extends flimsy\View{
    function display(){
    	print '<!DOCTYPE html><html><head><base href="/flimsy/src/test/" /><link rel="stylesheet" type="text/css" href="view/layout.css" /></head><body>';
        print '<h1>About</h1>';
        print '<a href="./">Home</a> <a href="about">About</a><br /><br />';
        print '</body></html>';
    }
}
?>
