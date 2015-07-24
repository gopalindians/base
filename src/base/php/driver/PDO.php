<?php

namespace base;

/**
 * PDO class. Handles connection and query to a database.
 *
 * @author Marvin Blum
 */
class PDO extends Database{
    /**
     * Creates a new PDO object and connects to database.
     *
     * @param type database type, e.g. "mysql"
     * @param host address
     * @param user
     * @param password
     * @param database
     * @param prefix use {prefix} in your queries to replace them, default is ''
     */
    function __construct($type, $host, $user, $password, $database, $prefix = '', $charset = self::DEFAULT_CHARSET){
        $this->prefix = $prefix;

        // connect
		try{
        	$this->con = @new \PDO($type.':host='.$host.';dbname='.$database, $user, $password, $options);
    	}
    	catch(\PDOException $e){
            throw new DbConnectionException();
        }
    }

    function __destruct(){
    	$this->con = null;
    }
}
?>
