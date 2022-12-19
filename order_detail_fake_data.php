<?php
require __DIR__ . '/parts/connect_db.php';

$order_sql = "SELECT `sid` FROM `order_list` ORDER BY `sid`";
$order_rows = $pdo->query($order_sql)->fetchAll();
$order_array = [];
foreach ($order_rows as $o_r) {
    array_push($order_array, $o_r['sid']);
}
// print_r($order_array);

$trails_sql = "SELECT `sid` FROM `trails`";
$trails_rows = $pdo->query($trails_sql)->fetchAll();
$trails_array = [];
foreach ($trails_rows as $t_r) {
    array_push($trails_array, $t_r['sid']);
}

$amount_array = ["1", "2", "3"];

$sql = "INSERT INTO `order_detail`(
    `order_sid`, 
    `trails_sid`, 
    `amount`,
    `create_date`
    ) VALUES (
        ?,
        ?,
        ?,
        NOW()
        )";

$stmt = $pdo->prepare($sql);

for ($i = 0; $i < count($order_array); $i++) {

    // 避免訂單裡面沒有訂購商品
    $order_sid_first = $order_array[$i];
    shuffle($trails_array);
    shuffle($amount_array);

    $trails_sid = $trails_array[0];
    $amount = $amount_array[0];

    $stmt->execute([
        $order_sid_first,
        $trails_sid,
        $amount
    ]);
}

for ($i = 0; $i < count($order_array); $i++) {

    shuffle($order_array);
    shuffle($trails_array);
    shuffle($amount_array);

    $order_sid = $order_array[0];
    $trails_sid = $trails_array[0];
    $amount = $amount_array[0];

    $stmt->execute([
        $order_sid,
        $trails_sid,
        $amount
    ]);
}

echo json_encode([
    $stmt->rowCount(), // 影響的資料筆數
    $pdo->lastInsertId(), // 最新的新增資料的主鍵
]);
