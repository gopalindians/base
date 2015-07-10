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
        \Exception::__construct(DbConnectionException::MESSAGE, DbConnectionException::CODE);
    }
}
?>
