<?php

namespace base;

/**
 * Exception thrown when a route file cannot be found.
 *
 * @author Marvin Blum
 */
class RouteFileNotFoundException extends \Exception{
    const MESSAGE = 'Could not find route file: ';
    const CODE = 5;

    function __construct($file){
        parent::__construct(self::MESSAGE.$file, self::CODE);
    }
}
?>
