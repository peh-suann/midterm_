<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin_required.php';

header('Content-Type: application/json');

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

if (empty($sid)) {
    header('location: comment.php');
    exit;
}
$pdo->query("DELETE FROM `rating` WHERE sid=$sid");
header('location: comment.php');
