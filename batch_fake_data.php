<?php
require __DIR__ . '/parts/connect_db.php';

$trails_sql = "SELECT `sid` FROM `trails`";
$trails_rows = $pdo->query($trails_sql)->fetchAll();
$trails_array = [];
foreach ($trails_rows as $t_r) {
    array_push($trails_array, $t_r['sid']);
}
// print_r($trails_array);

$sql = "INSERT INTO `batch`(
    `trail_sid`, 
    `batch_start`, 
    `batch_end`
    ) VALUES (
        ?,
        NOW(),
        NOW()
        )";

$stmt = $pdo->prepare($sql);

for ($i = 0; $i < count($trails_array); $i++) {

    // 避免訂單裡面沒有訂購商品
    $trails_array_first = $trails_array[$i];

    $stmt->execute([
        $trails_array_first
    ]);
}

for ($i = 0; $i < count($trails_array); $i++) {

    shuffle($trails_array);

    $trails_sid = $trails_array[0];
    print_r($trails_sid);

    $stmt->execute([
        $trails_sid
    ]);
}

echo json_encode([
    $stmt->rowCount(), // 影響的資料筆數
    $pdo->lastInsertId(), // 最新的新增資料的主鍵
]);
