<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: member.php'); // 轉向到列表頁
    exit;
}
$pdo->query("DELETE FROM `admin` WHERE sid=$sid");
// $pdo->query("DELETE FROM `member` WHERE sid=$sid");


header('Location: member.php');
