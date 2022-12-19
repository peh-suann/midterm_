<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header("Location: order.php");
  exit;
}

$product_sid = isset($_GET['product_sid']) ? intval($_GET['product_sid']) : 0;
if (empty($product_sid)) {
  header("Location: order.php");
  exit;
}

$sql = "UPDATE `order_detail` SET `fake_delete`=1 WHERE `sid`=$product_sid";
$pdo->query($sql);

if (empty($_SERVER['HTTP_REFERER'])) {
  header("Location: order.php");
} else {
  header("Location: order_edit.php?sid=$sid");
}
