<?php

namespace base;

/**
 * Exception thrown when a route file cannot be parsed.
 *
 * @author Marvin Blum
 */
class RouteFileParseException extends \Exception{
    const MESSAGE = 'Could not parse route file: ';
    const CODE = 6;

    function __construct($file){
        parent::__construct(self::MESSAGE.$file, self::CODE);
    }
}
?>
