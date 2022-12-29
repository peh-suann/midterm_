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
if (empty($_POST['account']) or empty($_POST['password']) or empty($_POST['password2'])) {
    $output['error'] = '資料不足';
    $output['code'] = 100;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$account = $_POST['account'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$isPass = true;

//email帳號驗證
if (empty($account) and !filter_var($account, FILTER_VALIDATE_EMAIL)) {
    $output['errors']['account'] = 'email格式錯誤';
    $isPass = false;
}
if ($isPass) {
    $sql = "INSERT INTO `admins`(
        `account`, `nickname`,`password_hash`
        ) VALUES (
        ?,?,?
        ) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $account,
        $nickname,
        password_hash($password, PASSWORD_DEFAULT)
    ]);
}
if ($stmt->rowCount()) {
    $output['success'] = true;
}



echo json_encode($output, JSON_UNESCAPED_UNICODE);
