<?php

namespace base;

/**
 * Exception thrown when database class cannot select database.
 *
 * @author Marvin Blum
 */
class DbSelectException extends \Exception{
    const MESSAGE = 'Could not select database!';
    const CODE = 4;

    function __construct(){
        parent::__construct(self::MESSAGE, self::CODE);
    }
}
?>
