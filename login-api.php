<?php

require __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');

if (!isset($_SESSION)) {
    session_start();
}
//設定輸出格式
$output = [
    'success' => false,
    'error' => '',
    'code' => 0, //除錯用
    'postData' => $_POST, //除錯用 
];

//沒有表單資料
if (empty($_POST['account'] or empty($_POST['password']))) {
    $output['error'] = '資料不足';
    $output['code'] = 100;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


$sql = "SELECT * FROM `admins` WHERE `account`=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['account']
]);

$r = $stmt->fetch();
if (empty($r)) {
    $output['error'] = '帳號或密碼錯誤';
    $output['code'] = 200;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//輸入密碼與資料庫密碼一樣 即success=true
$hash = $r['password_hash'];
$output['success'] = password_verify($_POST['password'], $hash);

if ($output['success']) {
    $output['code'] = 300;
    $_SESSION['admin'] = [
        'sid' => $r['sid'],
        'account' => $r['account'],
    ];
} else {
    $output['error'] = '帳號或密碼錯誤';
    $output['code'] = 400;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
