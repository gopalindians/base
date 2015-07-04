<?php namespace flimsy;
interface Database{
    /**
     * @param query SQL query
     * @return result object
     */
    function query($query);

    /**
     * Specialized version of query.
     *
     * @param query SQL query
     * @return selected result object
     */
    function select($query);

    /**
     * Specialized version of query.
     *
     * @param query SQL query
     * @return true if operation was successful, else false
     */
    function insert($query);

    /**
     * @param query pass substring starting at UPDATE
     * @return true if the entry was updated, else false
     */
    function update($query);

    /**
     * Specialized version of query.
     *
     * @param query SQL query
     * @return true if operation was successful, else false
     */
    function delete($query);
}

class DbConnectionException extends \Exception{
    const MESSAGE = 'Could not connect to database!';
    const CODE = 4;

    function __construct(){
        Exception::__construct(DbConnectionException::MESSAGE, DbConnectionException::CODE);
    }
}

class DbSelectException extends \Exception{
    const MESSAGE = 'Could not select database!';
    const CODE = 5;

    function __construct(){
        Exception::__construct(DbSelectException::MESSAGE, DbSelectException::CODE);
    }
}
?>
