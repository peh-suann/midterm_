<?php

require __DIR__ . '/parts/connect_db.php';

$output = [
  'success' => false,
  'code' => 0, // 除錯用
  'errors' => [],
  'postData' => $_POST, // 除錯用
];

// 表單要檢查嗎?

$sql = "INSERT INTO `coupon`(`promo_name`, `coupon_name`, `coupon_code`, `min_purchase`, `coupon_rate`, `start_date_coup`, `end_date_coup`, `coupon_status`) VALUES 
(?,?,?,
  ?,?,?,
  ?,?)";

$stmt = $pdo->prepare($sql);


$stmt->execute([
  $_POST['promo_name'],
  $_POST['coupon_name'],
  $_POST['coupon_code'],
  $_POST['min_purchase'],
  $_POST['coupon_rate'],
  $_POST['start_date_coup'],
  $_POST['end_date_coup'],
  $_POST['coupon_status'],
]);


//rowCount() bool 是否有新增一筆資料
if ($stmt->rowCount()) {

  $output['success'] = true;
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
