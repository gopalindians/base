<?php

namespace base;

/**
 * PDO class. Handles connection and query to a database.
 * Exceptions are enabled by default!
 *
 * @author Marvin Blum
 */
class PDO extends Database{
    const MYSQL = 'mysql';

    private $query = null;
    private $useTransactions = true;
    private $transactionStarted = false;

    /**
     * Creates a new PDO object and connects to database.
     *
     * @param type database type, e.g. "mysql"
     * @param host address
     * @param user
     * @param password
     * @param database
     * @param prefix use {prefix} in your queries to replace them, default is ''
     * @param disableAutocommit set to false for autocommit, default is true
     * @param charset the database charset, default @see Database
     */
    function __construct($type, $host, $user, $password, $database, $prefix = '', $disableAutocommit = true, $charset = self::DEFAULT_CHARSET){
        $this->prefix = $prefix;

        // connect
		try{
            $options = array();

            if(strtolower($type) == self::MYSQL){
                $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES \''.$charset.'\'';
            }

        	$this->con = @new \PDO($type.':host='.$host.';dbname='.$database, $user, $password, $options);
    	}
    	catch(\PDOException $e){
            throw new DbConnectionException();
        }

        // (optional) enable transactions
        if($disableAutocommit){
            $this->useTransactions = true;
            $this->setAttr(\PDO::ATTR_AUTOCOMMIT, false);
        }

        // enable exceptions by default
        $this->setAttr(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    function __destruct(){
    	$this->con = null;
    }

    private function beginTransaction(){
        if(!$this->useTransactions || $this->transactionStarted){
            return;
        }

        $this->transactionStarted = true;
        $this->con->beginTransaction();
    }

    /**
     * Sets a PDO attribute. For possible attributes visit: http://php.net/manual/en/pdo.setattribute.php
     *
     * @param attr the PDO attribute to set (int)
     * @param value the value to set (mixed)
     * @return true on success, false on failure
     */
    function setAttr($attr, $value){
        return $this->con->setAttribute($attr, $value);
    }

    /**
     * Returns a PDO attribute. For possible attributes visit: http://php.net/manual/en/pdo.getattribute.php
     *
     * @param attr the PDO attribute to set (int)
     * @return the attributes value or null on failure
     */
    function getAttr($attr){
        return $this->con->getAttribute($attr);
    }

    /**
     * Executes a simple query and returns result.
     * If you have enabled transactions, you need to commit/rollback for related queries (SELECTs do not require transactions).
     *
     * @param query the query to execute
     * @return an PDOStatement or null on failure
     */
    function query($query){
        $this->beginTransaction();
        $result = $this->con->query($query);

        if(!$result){
            return null;
        }

        return $result;
    }

    /**
     * Prepares a query for later usage. If transactions are enabled, a new one will be started if required.
     * To pass arguments, use ":arg" (notice the colon, without quotes) in query and pass them later to exec().
     *
     * @param query the query to prepare
     * @return void
     */
    function prepare($query){
        $this->beginTransaction();
        $this->query = $this->con->prepare($query);
    }

    /**
     * Binds a value to a key. Used together with prepare() and exec().
     *
     * @param key the key to bind the value to, without ":" in front
     * @param value the value to bind
     * @param type the type to bind, PDO::PARAM_STR by default (which is fine for most cases)
     * @return true if the value could be bound, else false
     */
    function bind($key, $value, $type = \PDO::PARAM_STR){
        if($this->query){
            $this->query->bindValue(':'.$key, $value, $type);
            return true;
        }

        return false;
    }

    /**
     * Executes a prepared statement and returns the PDOStatement object on success.
     *
     * @param params the params to bind, default is null; careful, you cannot use params and bind() together!
     * @return PDOStatement or null on failure
     */
    function exec(array $params = null){
        $result = null;

        if($this->query){
            $this->query->execute($params);
            $result = $this->query;
            $this->query = null;
        }

        return $result;
    }

    /**
     * @param query pass substring starting at FROM
     * @return result entry objects per row as an array
     */
    function select($query){
        $result = $this->query('SELECT '.$query);

        if($result){
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        }

        return null;
    }

    /**
     * @param query pass substring starting at INTO
     * @return true if the entry was inserted, else false
     */
    function insert($query){
        return $this->query('INSERT '.$query) != null;
    }

    /**
     * @param query pass substring starting at UPDATE
     * @return true if the entry was updated, else false
     */
    function update($query){
        return $this->query('UPDATE '.$query) != null;
    }

    /**
     * @param query pass substring starting at FROM
     * @return true if the entry was deleted, else false
     */
    function delete($query){
        return $this->query('DELETE '.$query) != null;
    }

    /**
     * @param query pass substring starting at table
     * @return true if the entry exists, else false
     */
    function exists($query){
        $result = $this->select('EXISTS(SELECT 1 FROM '.$query.') AS count');
        return $result[0]['count'] != 0;
    }

    /**
     * Call this method to commit your changes.
     * This is necessary if you have deactivatet autocommit (which it is by default).
     *
     * @return void
     */
    function commit(){
        if($this->transactionStarted){
            $this->con->commit();
            $this->transactionStarted = false;
        }
    }

    /**
     * Rollback all transactions since last commit.
     *
     * @return void
     */
    function rollback(){
        if($this->transactionStarted){
            $this->con->rollBack();
            $this->transactionStarted = false;
        }
    }

    /**
     * @return true if a transaction was started, else false
     */
    function inTransaction(){
        return $this->transactionStarted();
    }

    // inherit doc
    function escape($string){
        return $this->con->quote($string);
    }

    /**
     * Check SQL/PDO errors of last handle.
     *
     * @return array containing "code" and "message"
     */
    function error(){
        return array('code' => $this->con->errorCode(), 'message' => $this->con->errorInfo());
    }

    /**
     * Returns the ID of last inserted item, if called _before_ commit().
     *
     * @param name name of sequence object (optional, not required for MySQL)
     * @return ID of last inserted item
     */
    function lastId($name = null){
        return $this->con->lastInsertId($name);
    }
}
?>
