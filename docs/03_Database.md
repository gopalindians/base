# Database

*Requires revision*

*base* provides MySQL database access and an simple interface for other databases. We just discuss the MySQL class here, to keep things simple.
*MySQL* uses a mysqli PHP object to connect and work with your database. It is wrapped to shorten queries and to support usage of transactions. Transactions are activated by default and require a call to *commit()* to commit your changes. This is not required for selects, creating tables and so on (default behavior of mysqli). The connection will be closed when the object gets destroyed.

Example for simple queries:

```PHP
$db = new *base*\MySQL('host', 'user', 'password', 'database');

$db->query('CREATE TABLE ...'); // simply calls query of mysqli and returns result (mixed)
$db->select('FROM ...'); // adds SELECT in front of query and returns results AS AN ARRAY OF OBJECTS, which covers most (if not all) uses of an SELECT
$db->insert('...'); // analog to select
$db->delete('...'); // analog to select
$db->exists('...'); // adds EXISTS SELECT(SELECT 1 FROM in front of query, you need to provide the table and WHERE, the result will be true/false
$db->commit(); // commit your changes (INSERTs mostly)
$db->rollback(); // if called before commit(), all changes will be rolled back
```
