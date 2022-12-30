<?php
require __DIR__ . '/parts/connect_db.php';


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

if (empty($sid)) {
    header('Location:trails.php');
    exit;
}

$pdo->query("DELETE FROM `trails` WHERE sid=$sid");
header('Location:trails.php');

if (empty($_SERVER['HTTP_REFERER'])) {
    header('Location:trails_detail.php');
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}