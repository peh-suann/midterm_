<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header('Location: member.php'); // 轉向到列表頁
  exit;
}


$sql = "UPDATE `member` SET `display`=? WHERE sid=?";
$stmt = $pdo->prepare($sql);

$stmt->execute([
  0,
  $sid
]);

header('Location: member.php');

// echo "<script>history.go(-3)</script>";

// // TODO:研究刪除後要跳到哪個頁面, 不要讓頁面一直跳轉
// if(empty($_SERVER['HTTP_REFERER'])){
//     header('Location: member.php');
//   } else {
//     // 回到原本刪除的頁面 (HTTP_REFERER)
//     header('Location: '. $_SERVER['HTTP_REFERER']);  
//   }