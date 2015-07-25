<?php

namespace base;

/**
 * Abstract base class for database drivers.
 *
 * @author Marvin Blum
 */
abstract class Database{
	const DEFAULT_CHARSET = 'latin1'; // MySQL default
    const PREFIX_PATTERN = '{prefix}';

    protected $con = null;
    protected $prefix;

    abstract function select($query);
    abstract function insert($query);
    abstract function update($query);
    abstract function delete($query);
    abstract function exists($query);
    abstract function commit();
    abstract function rollback();

    /**
     * Escapes a string for database insertion.
     *
     * @param string the string to escape
     * @return escaped string
     */
    function escape($string){
        return $this->con->escape_string($string); // MySQL
    }
}
?>
