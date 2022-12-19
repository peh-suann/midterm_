<?php

require __DIR__ . '/parts/connect_db.php';

$account = 'pehsuann';
$password = 'mountain';

$sql = "INSERT INTO `admins`(`account`, `password_hash`) VALUES(?,?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $account,
    password_hash($password, PASSWORD_DEFAULT)
]);

echo 'ok';