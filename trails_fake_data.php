<?php
require __DIR__ . '/parts/connect_db.php';

$sql_sid = "SELECT `sid` FROM `trails`";
$trails_sid = $pdo->query($sql_sid)->fetchAll();
$max_num = max($trails_sid)['sid'];
print_r($trails_sid);

$country = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20"];
$diff = ["1","2","3"];

$sql = "UPDATE `trails` SET 
`geo_location_sid`=?,
`difficulty_list_sid`=?
 WHERE `sid`=?
 ";

for ($i = 1; $i <= $max_num; $i++) {
    shuffle($country);
    shuffle($diff);
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $country[0],
        $diff[0],
        $i
    ]);
}
