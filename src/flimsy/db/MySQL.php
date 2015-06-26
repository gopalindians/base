<?php

require_once 'Database.php';

class MySQL implements Database{
	const DEFAULT_CHARSET = 'ISO-8859-1';

	private $con = null;

	/*
	 * Creates a new MySQL object and connects to database.
	 *
	 * @param host address
	 * @param user
	 * @param password
	 * @param database
	 * @param disables autocommit, default is true
	 */
	function __construct($host, $user, $password, $database, $disableAutocommit = true){
		$this->con = @new mysqli($host, $user, $password);

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

		$this->con->set_charset(MySQL::DEFAULT_CHARSET);
	}

	function __destruct(){
		$this->con->close();
	}

	/*
 	 * @param, query
 	 * @return mysqli result object
	 */
    function query($query){
        return $this->con->query($query);
    }

    /*
 	 * @param query, pass substring starting at FROM
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

    /*
 	 * @param query, pass substring starting at INTO
 	 * @return true if the entry was inserted, else false
     */
    function insert($query){
    	return $this->query('INSERT '.$query);
    }

    /*
	 * @param query, pass substring starting at FROM
	 * @return true if the entry was deleted, else false
     */
    function delete($query){
    	return $this->query('DELETE '.$query);
    }

    /*
	 * @param query, pass substring starting at table
	 * @return true if the entry exists, else false
     */
    function exists($query){
		$result = $this->select('EXISTS(SELECT 1 FROM '.$query.') AS count');
    	return $result[0]->count != 0;
    }

    /*
 	 * Call this method to commit your changes.
 	 * This is necessary if you have deactivatet autocommit (which it is by default).
     */
    function commit(){
    	$this->con->autocommit(true);
    	$this->con->commit();
    	$this->con->autocommit(false);
    }

    /*
 	 * Rollback all transactions since last commit.
     */
    function rollback(){
    	$this->con->rollback();
    }
}
?>
