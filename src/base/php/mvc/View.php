<?php

namespace base;

/**
 * MVC view class. Used to display a page.
 *
 * @author Marvin Blum
 */
abstract class View{
    /**
     * Abstract method used to render current view.
     *
     * @return void
     */
    abstract function display();
}
?>
