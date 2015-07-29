<?php
$pdo = new base\PDO('mysql', 'localhost', 'root', '', 'base');

print 'simple query<br>';
$result = $pdo->query('SELECT * FROM test');
base\dump($result);

print 'select<br>';
base\dump($pdo->select('* FROM test'));

print 'prepare and exec<br>';
$pdo->prepare('SELECT * FROM test WHERE id = :id');
base\dump($pdo->exec(array('id' => 1))->fetchAll(PDO::FETCH_ASSOC));

print 'delete + commit<br>';
base\dump($pdo->delete('FROM test'));
$pdo->commit();

print 'insert + rollback<br>';
base\dump($pdo->insert('INTO test (a, b) VALUES ("g", "h")'));
base\dump($pdo->insert('INTO test (a, b) VALUES ("k", "l")'));
base\dump($pdo->insert('INTO test (a, b) VALUES ("5", "6")'));
$pdo->rollback();

print 'insert + commit<br>';
base\dump($pdo->insert('INTO test (a, b) VALUES ("i", "j")'));
$pdo->commit();

print 'update + commit | exists';
$a = 'update';
base\dump($pdo->update('test SET a = '.$pdo->escape($a)));
$pdo->commit();

base\dump($pdo->exists('test WHERE a = '.$pdo->escape($a)));

print 'delete + rollback<br>';
base\dump($pdo->delete('FROM test WHERE a = '.$pdo->escape($a)));
$pdo->rollback();

print 'insert prepare and exec + bind';
$pdo->prepare('INSERT INTO test (a, b) VALUES (:a, :b)');
$pdo->bind('a', 'foo');
$pdo->bind('b', 'bar');
$pdo->exec();
base\dump($pdo->lastId());
$pdo->commit();
?>
