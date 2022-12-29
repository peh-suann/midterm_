<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header('Location: coupon_list.php'); // 轉向到列表頁
  exit;
}


$sql = "UPDATE `coupon` SET `display`=? WHERE sid=?";
$stmt = $pdo->prepare($sql);

$stmt->execute([
  0,
  $sid
]);

if(empty($_SERVER['HTTP_REFERER'])){
  header('Location: coupon_list.php');
} else {
  header('Location: '. $_SERVER['HTTP_REFERER']);
}
