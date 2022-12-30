<?php require __DIR__ . '/parts/connect_db.php';
$pageName = "trails_detail";
$title = "trails_detail";


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location:trails.php');
    exit;
}



$sql = "SELECT `trail_name`,`trail_img`,`trail_describ`,`trail_timetable`, `trail_time`, `geo_location_sid`, `difficulty_list_sid`, `coupon_status`, `price`, `memo`, `equipment`,`trails_display` FROM `trails` WHERE sid=$sid";

$trails_details = $pdo->query($sql)->fetchAll();

?>

<style>
.trails_card .col {
    text-align: center;
}
</style>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>



<div class="container">
    <div class="row">
        <div class="m-3">
            <button type="button" class="btn btn-primary" onclick="goback()">返回商品</button>
            <!-- <button type="button" class="btn btn-primary" onclick="goback()"><a href="./trails_detail_api.php" class="text-decoration-none"
                    style="color:white;">返回商品</a></button> -->
        </div>
        <div class="trails_card">
            <div class="trails_add_card_body p-4">
                <h1 class="trails_add_card_title pb-4 ">商品詳細內容</h1>
                <input type="hidden" name="sid" value="<?= $t_d['trail_sid'] ?>">
                <table>
                    <?php foreach ($trails_details as $t_d) : ?>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">名稱</td>
                        <td class="col"><?= $t_d['trail_name'] ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">圖片</td>
                        <td class="col"><img src="./trails_uploaded/<?= $t_d['trail_img'] ?>" alt="" class="w-50"></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">描述</td>
                        <td class="col"><?= $t_d['trail_describ'] ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">行程規劃</td>
                        <td class="col"><?= $t_d['trail_timetable'] ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">行程時長</td>
                        <td class="col"><?= $t_d['trail_time'] ?>小時</td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">地理位置</td>
                        <td class="col"><?php if ($t_d['geo_location_sid'] == 1) {
                                                echo '台北市';
                                            } else if ($t_d['geo_location_sid'] == 2) {
                                                echo '新北市';
                                            } else if ($t_d['geo_location_sid'] == 3) {
                                                echo '桃園市';
                                            } else if ($t_d['geo_location_sid'] == 4) {
                                                echo '台中市';
                                            } else if ($t_d['geo_location_sid'] == 5) {
                                                echo '台南市';
                                            } else if ($t_d['geo_location_sid'] == 6) {
                                                echo '高雄市';
                                            } else if ($t_d['geo_location_sid'] == 7) {
                                                echo '基隆市';
                                            } else if ($t_d['geo_location_sid'] == 8) {
                                                echo '新竹市';
                                            } else if ($t_d['geo_location_sid'] == 9) {
                                                echo '嘉義市';
                                            } else if ($t_d['geo_location_sid'] == 10) {
                                                echo '新竹縣';
                                            } else if ($t_d['geo_location_sid'] == 11) {
                                                echo '苗栗縣';
                                            } else if ($t_d['geo_location_sid'] == 12) {
                                                echo '彰化縣';
                                            } else if ($t_d['geo_location_sid'] == 13) {
                                                echo '南投縣';
                                            } else if ($t_d['geo_location_sid'] == 14) {
                                                echo '雲林縣';
                                            } else if ($t_d['geo_location_sid'] == 15) {
                                                echo '嘉義縣';
                                            } else if ($t_d['geo_location_sid'] == 16) {
                                                echo '屏東縣';
                                            } else if ($t_d['geo_location_sid'] == 17) {
                                                echo '宜蘭縣';
                                            } else if ($t_d['geo_location_sid'] == 18) {
                                                echo '花蓮縣';
                                            } else if ($t_d['geo_location_sid'] == 19) {
                                                echo '台東縣';
                                            } else {
                                                echo '澎湖縣';
                                            }
                                            ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">難易度</td>
                        <td class="col"><?php if ($t_d['difficulty_list_sid'] == 1) {
                                                echo '簡單';
                                            } else if ($t_d['difficulty_list_sid'] == 2) {
                                                echo '中等';
                                            } else {
                                                echo '困難';
                                            }
                                            ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">可否使用優惠碼</td>
                        <td class="col">
                            <?php if ($t_d['coupon_status'] == 0) {
                                    echo '否';
                                } else {
                                    echo '是';
                                } ?>
                        </td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">價格</td>
                        <td class="col"><?= $t_d['price'] ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">備註</td>
                        <td class="col"><?= $t_d['memo'] ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid rgb(211, 211, 211)">
                        <td class="col-2">裝備說明</td>
                        <td class="col"><?= $t_d['equipment'] ?></td>
                    </tr>

                    <tr>
                        <td class="col-2">商品狀態</td>
                        <td class="col">
                            <?php if ($t_d['trails_display'] == 0) {
                                    echo '未上架';
                                } else {
                                    echo '已上架';
                                } ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
function goback() {
    location.href = document.referrer;
}
</script>

<?php require __DIR__ . '/parts/html-foot.php' ?>