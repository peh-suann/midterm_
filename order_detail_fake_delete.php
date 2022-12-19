<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header("Location: order.php");
  exit;
}

$sql = "UPDATE `order_list` SET `fake_delete`=1 WHERE sid=$sid";
$pdo->query($sql);

if (empty($_SERVER['HTTP_REFERER'])) {
  header("Location: order.php");
} else {
  header("Location: order.php");
}
