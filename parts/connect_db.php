<?php

// define('PROJ_ROOT', '/myProject/PEH-SUANN');

// $db_host = 'localhost';
// $db_user = 'root';
// $db_pass = '20000830';
// $db_name= 'peh-suann';

define('PROJ_ROOT', '/myProject/PEH-SUANN');

$db_host = '192.168.21.84';
$db_user = 'mountain';
$db_pass = 'mountaindude55';
$db_name = 'mountain';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";

$pdo_options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);