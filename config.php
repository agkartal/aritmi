<?php

$databaseHost = 'localhost:3306';
$databaseName = '***';
$databaseUsername = '***';
$databasePassword = '***';

$mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
$mysqli->set_charset("utf8");
?>