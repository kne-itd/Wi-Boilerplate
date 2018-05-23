<?php
require_once '../config.php';
require_once 'scaffold/Scaffold.php';

$scaffold = new Scaffold($conn, DB_DATABASE);

$result = $scaffold->WriteClasses('../m', 'bilbixen_', TRUE, TRUE);

foreach ($result as $value) {
    echo $value;
    echo '<br>';
}
//var_dump($seed);