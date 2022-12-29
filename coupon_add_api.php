<?php

require __DIR__ . '/parts/connect_db.php';

$output = [
  'success' => false,
  'code' => 0, // 除錯用
  'errors' => [],
  'postData' => $_POST, // 除錯用
];

// 沒有表單資料
if (empty($_POST)) {
  $output['errors'] = ['all' => '沒有表單資料'];
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

$promo_name = $_POST['promo_name'] ?? '';
$coupon_name = $_POST['coupon_name'] ?? '';
$coupon_code = $_POST['coupon_code'] ?? '';
$min_purchase = $_POST['min_purchase'] ?? '';
$coupon_rate = $_POST['coupon_rate'] ?? '';
$start_date_coup = $_POST['start_date_coup'] ?? '';
$end_date_coup = $_POST['end_date_coup'] ?? '';
$coupon_status = $_POST['coupon_status'] ?? '';


// FIXME:修改表單驗證
$isPass = true;

if (mb_strlen($coupon_name, 'utf8') < 3) {
  $output['errors']['coupon_name'] = '請輸入兩字以上';
  $isPass = false;
}

if (mb_strlen($coupon_code, 'utf8') < 1) {
  $output['errors']['coupon_code'] = '請輸入正確的優惠券代碼';
  $isPass = false;
}

if (empty($min_purchase)) {
  $output['errors']['min_purchase'] = '請輸入最低消費金額';
  $isPass = false;
}

if (empty($coupon_rate)) {
  $output['errors']['coupon_rate'] = '請輸入折扣';
  $isPass = false;
}

if (empty($start_date_coup)) {
  $output['errors']['start_date_coup'] = '請輸入適用開始期限';
  $isPass = false;
}

if (empty($end_date_coup)) {
  $output['errors']['end_date_coup'] = '請輸入適用結束期限';
  $isPass = false;
}

if ($isPass) {
  $sql = "INSERT INTO `coupon`(`promo_name`, `coupon_name`, `coupon_code`, `min_purchase`, `coupon_rate`, `start_date_coup`, `end_date_coup`, `coupon_status`, `display`) VALUES 
(?,?,?,
  ?,?,?,
  ?,?,?)";

  $stmt = $pdo->prepare($sql);


  $stmt->execute([
    $promo_name,
    $coupon_name,
    $coupon_code,
    $min_purchase,
    $coupon_rate,
    $start_date_coup,
    $end_date_coup,
    $coupon_status,
    1
  ]);


  //rowCount() bool 是否有新增一筆資料
  if ($stmt->rowCount()) {

    $output['success'] = true;
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
