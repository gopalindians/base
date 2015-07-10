<?php

namespace base;

/**
 * MySQL class. Handles connection and query to a MySQL database.
 *
 * @author Marvin Blum
 */
class MySQL{
    const DEFAULT_CHARSET = 'ISO-8859-1';
    const PREFIX_PATTERN = '{prefix}';

    private $con = null;
    private $prefix;

    /**
     * Creates a new MySQL object and connects to database.
     *
     * @param host address
     * @param user
     * @param password
     * @param database
     * @param prefix use {prefix} in your queries to replace them, default is ''
     * @param disableAutocommit disables autocommit, default is true
     */
    function __construct($host, $user, $password, $database, $prefix = '', $disableAutocommit = true, $charset = self::DEFAULT_CHARSET){
        $this->con = @new \mysqli($host, $user, $password);
        $this->prefix = $prefix;

        if($this->con->connect_error){
            throw new DbConnectionException();
        }

        if(!$this->con->select_db($database)){
            throw new DbSelectException();
        }

        // config
        if($disableAutocommit){
            $this->con->autocommit(false);
        }

        $this->con->set_charset($charset);
    }

    function __destruct(){
        $this->con->close();
    }

    /**
     * @param query
     * @return mysqli result object
     */
    function query($query){
        return $this->con->query(str_replace(self::PREFIX_PATTERN, $this->prefix, $query));
    }

    /**
     * @param query pass substring starting at FROM
     * @return result entry objects per row as an array
     */
    function select($query){
        $result = $this->query('SELECT '.$query);

        if(is_bool($result)){
            return null;
        }

        $data = array();

        while($row = $result->fetch_object()){
            $data[] = $row;
        }

        return $data;
    }

    /**
     * @param query pass substring starting at INTO
     * @return true if the entry was inserted, else false
     */
    function insert($query){
        return $this->query('INSERT '.$query);
    }

    /**
     * @param query pass substring starting at UPDATE
     * @return true if the entry was updated, else false
     */
    function update($query){
        return $this->query('UPDATE '.$query);
    }

    /**
     * @param query pass substring starting at FROM
     * @return true if the entry was deleted, else false
     */
    function delete($query){
        return $this->query('DELETE '.$query);
    }

    /**
     * @param query pass substring starting at table
     * @return true if the entry exists, else false
     */
    function exists($query){
        $result = $this->select('EXISTS(SELECT 1 FROM '.$query.') AS count');
        return $result[0]->count != 0;
    }

    /**
     * Call this method to commit your changes.
     * This is necessary if you have deactivatet autocommit (which it is by default).
     *
     * @return void
     */
    function commit(){
        $this->con->autocommit(true);
        $this->con->commit();
        $this->con->autocommit(false);
    }

    /**
     * Rollback all transactions since last commit.
     *
     * @return void
     */
    function rollback(){
        $this->con->rollback();
    }

    /**
     * Escapes a string for database insertion.
     *
     * @param string the string to escape
     * @return escaped string
     */
    function escape($string){
        return $this->con->escape_string($string);
    }
}
?>
