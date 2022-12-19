<?php
require __DIR__ . '/parts/connect_db.php';

$member_sql = "SELECT `sid` FROM `member`";
$member_rows = $pdo->query($member_sql)->fetchAll();
$member_array = [];
foreach ($member_rows as $m_r) {
    array_push($member_array, $m_r['sid']);
}

$price_sql = "SELECT `price` FROM `trails`";
$price_rows = $pdo->query($price_sql)->fetchAll();
$price_array = [];
foreach ($price_rows as $p_r) {
    array_push($price_array, $p_r['price']);
}

$status_sql = "SELECT `sid` FROM `order_status`";
$status_rows = $pdo->query($status_sql)->fetchAll();
$status_array = [];
foreach ($status_rows as $s_r) {
    array_push($status_array, $s_r['sid']);
}

$sql = "INSERT INTO `order_list`(
    `order_date`, 
    `member_sid`, 
    `order_status_sid`, 
    `total`
    ) VALUES (
        NOW(),
        ?,
        ?,
        ?
        )";

$stmt = $pdo->prepare($sql);

for ($i = 0; $i < 100; $i++) {

    shuffle($member_array);
    shuffle($status_array);
    shuffle($price_array);

    $member_sid = $member_array[0];
    $order_status_sid = $status_array[0];
    $total = $price_array[0];

    $stmt->execute([
        $member_sid,
        $order_status_sid,
        $total
    ]);
}

echo json_encode([
    $stmt->rowCount(), // 影響的資料筆數
    $pdo->lastInsertId(), // 最新的新增資料的主鍵
]);
