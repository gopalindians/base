<?php

namespace base;

/**
 * Exception thrown when database class cannot connect to database.
 *
 * @author Marvin Blum
 */
class DbConnectionException extends \Exception{
    const MESSAGE = 'Could not connect to database!';
    const CODE = 3;

    function __construct(){
        parent::__construct(self::MESSAGE, self::CODE);
    }
}
?>
