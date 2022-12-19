<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header("Location: order.php");
  exit;
}

$sql = "DELETE FROM `order_list` WHERE sid=$sid";
$pdo->query($sql);

// 回到還沒變更前的狀態
// echo "<script>history.go(-2)</script>";

if (empty($_SERVER['HTTP_REFERER'])) {
  header("Location: order.php");
} else {
  header("Location: order.php");
}