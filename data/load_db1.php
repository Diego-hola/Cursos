<?php
$db = new PDO('sqlite:' . realpath(__DIR__) . '/cursos2.db');
$fh = fopen(__DIR__ . '/cursos.sql', 'r');
while ($line = fread($fh, 4096)) {
    $db->exec($line);
}
fclose($fh);