<?php


require __DIR__ . '/parts/connect_db.php';

// 設定後端輸出的content-type
header('Content-Type: application/json');

// 設定輸出的格式, 輸出讓前端知道資料新增有沒有成功
$output = [
    'success' => false,
    'code' => 0, // 除錯用
    'errors' => [],
    'postData' => $_POST, // 除錯用
];

if (empty($_POST)) {
    $output['errors'] = ['all' => '沒有表單資料'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//定義變數與POST過來的資料
$member = $_POST['member'] ?? '';
$score = $_POST['score'] ?? '';
$trails = $_POST['trails'] ?? '';
$comment_text = $_POST['comment_text'] ?? '';
$submit_time = '';


$isPass = true;
if ($isPass) {
    $sql = "INSERT INTO `rating`(
        `member_sid`, `trails_sid`, 
        `score`, `rate_date`,`comment`
        ) VALUES (
            ?,?,
            ?,
            NOW(),?
        )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $member,
        $trails,
        $score,
        $comment_text,
    ]);
    if ($stmt->rowCount()) {
        $output['msg'] = '會員新增成功';
    }
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
