<?php

namespace base;

/**
 * Exception thrown when a navigation node could not be found.
 *
 * @author Marvin Blum
 */
class NavigatioNodeNotFoundException extends \Exception{
    const MESSAGE = 'Could not find navigation node with ID: ';
    const CODE = 7;

    function __construct($id){
        parent::__construct(self::MESSAGE.$id, self::CODE);
    }
}
?>
