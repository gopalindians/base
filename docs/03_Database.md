# Database

*base* provides database access using mysqli and PDO driver.
Both are based on abstract class *Database*.

## MySQL

*MySQL* uses a mysqli PHP object to connect and work with your database. It is wrapped to shorten queries and to support usage of transactions. Transactions are activated by default and require a call to *commit()* to commit your changes. This is not required for selects, creating tables and so on (default behavior of mysqli). The connection will be closed when the object gets destroyed.

Example for simple queries:

```PHP
// this will connect and select database, or throw error on failure
$db = new base\MySQL('host', 'user', 'password', 'database');

// simply calls query of mysqli and returns result (mixed)
$db->query('CREATE TABLE ...');

// adds SELECT in front of query and returns results AS AN ARRAY OF OBJECTS, which covers most (if not all) uses of an SELECT
$db->select('FROM ...');

$db->insert('...'); // analog to select
$db->delete('...'); // analog to select

// adds EXISTS SELECT(SELECT 1 FROM in front of query, you need to provide the table and WHERE, the result will be true/false
$db->exists('...');

// commit your changes (INSERTs mostly)
$db->commit();

// ... or, if called before commit(), all changes will be rolled back
$db->rollback();
```

## PDO

PDO can be used for many databases, but it basically works like *MySQL*.
You can select, insert, ... rollback and commit just like with *MySQL*. The main difference are named attributes and statement preparation (which you don't need, if you use provided methods):

```PHP
// just like MySQL
$db = new base\PDO('host', 'user', 'password', 'database');

// prepare and execute a statement
$pdo->prepare('SELECT * FROM test WHERE id = :id');
$pdo->exec(array('id' => 1))->fetchAll(PDO::FETCH_ASSOC);

// prepare, execute and commit a statement
$pdo->prepare('INSERT INTO test (a, b) VALUES (:a, :b)');
$pdo->bind('a', 'foo'); // we can use bind() to set our attributes
$pdo->bind('b', 'bar');
$pdo->exec(); // execute with bound parameters, do not pass an array in this case!
base\dump($pdo->lastId()); // this will print the ID of new item
$pdo->commit(); // commit insert
```

For the last example we could have also used:

```PHP
$pdo->prepare('INSERT INTO test (a, b) VALUES (:a, :b)');
$pdo->exec(array('a' => 'foo', 'b' => 'bar')); // without bind
base\dump($pdo->lastId());
$pdo->commit();
```
