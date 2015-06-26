<?php

/*
 * Interface for database connections.
 * The methods are representing minimum requirements.
 */
interface Database{
    function query($query);
    function select($query);
    function insert($query);
    function delete($query);
}

class DbConnectionException extends \Exception{
	const MESSAGE = 'Could not connect to database!';

	function __construct(){
		Exception::__construct(DbConnectionException::MESSAGE);
	}
}

class DbSelectException extends \Exception{
	const MESSAGE = 'Could not select database!';

	function __construct(){
		Exception::__construct(DbSelectException::MESSAGE);
	}
}
?>
