<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin_required.php';

// header('Content-Type: application/json');

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

if (empty($sid)) {
    header('location: admin.php');
    exit;
}
$pdo->query("DELETE FROM `admins` WHERE sid=$sid");

// header(`location: comment.php?page={$sid}`)
if (isset($_SERVER['HTTP_REFERER'])) {
    header('location: admin.php');
} else {
    header('location:' . $_SERVER['HTTP_REFERER']);
}
