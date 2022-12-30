<?php
require __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'code' => 999, // 除錯用
    'errors' => [],
    'postData' => $_POST, // 除錯用
];
// $output['code'] = "100";
$sid = $_POST['sid'];
$account = $_POST['account'] ?? '';
$nickname = $_POST['nickname'] ?? '';
$isPass = true;

if (empty(intval($sid))) {
    $output['errors'] = ['sid' => '沒有資料主鍵'];
    $output['code'] = "100";

    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
} else {
    $output['success'] = true;
    $output['code'] = "200";
}


$edit_sql = "UPDATE `admins` SET 
    `account`=?, 
    `nickname`=? WHERE sid=?";
// $output['error'] = '400';
// $sql2 = "UPDATE `admins` SET `sid`='?',`account`='?',`nickname`='?', WHERE `sid`=?";
// header('location: comment.php');
$stmt = $pdo->prepare($edit_sql);
$stmt->execute([
    $account,
    $nickname,
    $sid
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
    $output['code'] = "";
    $output['errors'] = '資料已更新';
} else {
    $output['code'] = "here";
    $output['errors'] = '資料沒有變更';
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
// if (isset($_SERVER['HTTP_REFERER'])) {
//     header('location: comment.php');
// } else {
//     header('location:' . $_SERVER['HTTP_REFERER']