<?php
require __DIR__ . '/parts/connect_db.php';
$padeName = 'edit';
$title = '修改通訊錄';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

if (empty($sid)) {
    header('Location:trails.php');
    exit;
}

$sql = "SELECT * FROM `trails` WHERE sid=$sid";

$row = $pdo->query($sql)->fetch();

if (empty($row)) {
    header('Location:trails.php');
    exit;
}


?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>

<style>
    .trails_add_card_title {
        border-bottom: 1px solid rgb(211, 211, 211);
        padding: 20px;
        margin-bottom: 20px;
    }

    .trails_add_card_body {
        border: 1px solid rgb(211, 211, 211);
        border-radius: 20px;
    }
</style>

<div class="container">
    <div class="row">

        <div class="trails_card">
            <a href="./trails.php" class="text-decoration-none" style="color:white;"><button type="button" class="btn btn-primary m-3">返回</button></a>

            <div class="col-6 trails_add_card_body p-4">
                <h1 class="trails_add_card_title">編輯商品</h1>

                <form name="form1" style="display:none;">
                    <input type="file" name="trail_image" accept="image/*" />
                </form>
                <form name="trails_form" onsubmit="checkForm(event)">

                    <input type="hidden" name="sid" value="<?= $row['sid'] ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">名稱</label>
                        <input type="trail_name" class="form-control" id="trail_name" name="trail_name" value="<?= htmlentities($row['trail_name']) ?>">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">圖片</label>
                    </div>
                    <div onclick="trail_image.click()" class="trails_picture p-2">上傳圖片</div>
                    <img id="myimg" src="./trails_uploaded/<?= $row['trail_img'] ?>" alt="" width="200px">
                    <input type="text" name="trail_img" value="<?= $row['trail_img'] ?>" class="w-100 mb-2">

                    <label class="form-label me-2">描述</label>
                    <div class="mb-3 d-flex">
                        <textarea name="trail_describ" id="trail_describ" cols="100" rows="4"><?= htmlentities($row['trail_describ']) ?></textarea>
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">簡述</label>
                        <input type="text" class="form-control" id="trail_short_describ" aria-describedby="emailHelp" name="trail_short_describ" value="<?= htmlentities($row['trail_short_describ']) ?>">
                    </div>

                    <label class="form-label me-2">行程規劃</label>
                    <div class="mb-3 d-flex">
                        <textarea name="trail_timetable" id="trail_timetable" cols="100" rows="4"><?= htmlentities($row['trail_timetable']) ?></textarea>
                        <div class="form-text"></div>
                    </div>

                    <label class="form-label">行程時長</label>
                    <div class="mb-3 d-flex">
                        <input type="number" class="form-control w-50" id="trail_time" aria-describedby="emailHelp" name="trail_time" value="<?= htmlentities($row['trail_time']) ?>">
                        <div class="p-2">小時</div>
                    </div>

                    <div class="mb-2">地理位置</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="geo_location_sid" id="geo_location_sid">
                        <option value="">請選擇縣市</option>
                        <option value="1" <?= $row['geo_location_sid'] == 1 ? 'selected' : '' ?>>台北市</option>
                        <option value="2" <?= $row['geo_location_sid'] == 2 ? 'selected' : '' ?>>新北市</option>
                        <option value="3" <?= $row['geo_location_sid'] == 3 ? 'selected' : '' ?>>桃園市</option>
                        <option value="4" <?= $row['geo_location_sid'] == 4 ? 'selected' : '' ?>>台中市</option>
                        <option value="5" <?= $row['geo_location_sid'] == 5 ? 'selected' : '' ?>>台南市</option>
                        <option value="6" <?= $row['geo_location_sid'] == 6 ? 'selected' : '' ?>>高雄市</option>
                        <option value="7" <?= $row['geo_location_sid'] == 7 ? 'selected' : '' ?>>基隆市</option>
                        <option value="8" <?= $row['geo_location_sid'] == 8 ? 'selected' : '' ?>>新竹市</option>
                        <option value="9" <?= $row['geo_location_sid'] == 9 ? 'selected' : '' ?>>嘉義市</option>
                        <option value="10" <?= $row['geo_location_sid'] == 10 ? 'selected' : '' ?>>新竹縣</option>
                        <option value="11" <?= $row['geo_location_sid'] == 11 ? 'selected' : '' ?>>苗栗縣</option>
                        <option value="12" <?= $row['geo_location_sid'] == 12 ? 'selected' : '' ?>>彰化縣</option>
                        <option value="13" <?= $row['geo_location_sid'] == 13 ? 'selected' : '' ?>>南投縣</option>
                        <option value="14" <?= $row['geo_location_sid'] == 14 ? 'selected' : '' ?>>雲林縣</option>
                        <option value="15" <?= $row['geo_location_sid'] == 15 ? 'selected' : '' ?>>嘉義縣</option>
                        <option value="16" <?= $row['geo_location_sid'] == 16 ? 'selected' : '' ?>>屏東縣</option>
                        <option value="17" <?= $row['geo_location_sid'] == 17 ? 'selected' : '' ?>>宜蘭縣</option>
                        <option value="18" <?= $row['geo_location_sid'] == 18 ? 'selected' : '' ?>>花蓮縣</option>
                        <option value="19" <?= $row['geo_location_sid'] == 19 ? 'selected' : '' ?>>台東縣</option>
                        <option value="20" <?= $row['geo_location_sid'] == 20 ? 'selected' : '' ?>>澎湖縣</option>
                        <div class="form-text"></div>
                    </select>

                    <div class="mb-2">難易度</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="difficulty_list_sid" id="difficulty_list_sid">
                        <option value="">請選擇難易度</option>
                        <option value="1" <?= $row['difficulty_list_sid'] == 1 ? 'selected' : '' ?>>簡單</option>
                        <option value="2" <?= $row['difficulty_list_sid'] == 2 ? 'selected' : '' ?>>中等</option>
                        <option value="3" <?= $row['difficulty_list_sid'] == 3 ? 'selected' : '' ?>>困難</option>
                        <div class="form-text"></div>
                    </select>

                    <div class="mb-2">可否使用優惠券</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="coupon_status" id="coupon_status">
                        <option value="">請選擇可否使用優惠券</option>
                        <option value="1" <?= $row['coupon_status'] == 1 ? 'selected' : '' ?>>可</option>
                        <option value="0" <?= $row['coupon_status'] == 0 ? 'selected' : '' ?>>否</option>
                        <div class="form-text"></div>
                    </select>

                    <div class="mb-3">
                        <label class="form-label">價格</label>
                        <input type="text" class="form-control" id="price" aria-describedby="emailHelp" name="price" value="<?= htmlentities($row['price']) ?>">
                    </div>
                    <div class="mb-3 d-flex">
                        <label class="form-label me-2">備註:</label>
                        <textarea name="memo" id="memo" cols="100" rows="4"><?= htmlentities($row['memo']) ?></textarea>
                    </div>
                    <div class="mb-3 d-flex">
                        <label class="form-label me-2">裝備說明:</label>
                        <textarea name="equipment" id="equipment" cols="100" rows="4"><?= htmlentities($row['equipment']) ?></textarea>
                    </div>

                    <div class="mb-2">商品狀態</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="trails_display" id="trails_display">
                        <option value="">請選擇商品狀態</option>
                        <option value="1" <?= $row['trails_display'] == 1 ? 'selected' : '' ?>>已上架</option>
                        <option value="0" <?= $row['trails_display'] == 0 ? 'selected' : '' ?>>未上架</option>
                        <div class="form-text"></div>
                    </select>

                    <button type="submit" class="btn btn-primary">編輯</button>
                </form>

            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
    const rowData = <?= json_encode($row, JSON_UNESCAPED_UNICODE) ?>;
    const checkForm = function(event) {
        event.preventDefault();

        const fd = new FormData(document.trails_form);

        fetch('trails_edit_api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (obj.success) {
                alert('編輯成功');
                // history.go(-1);
                location.href = document.referrer;
            }
        })
    };

    const trail_image = document.form1.trail_image;

    trail_image.onchange = function(event) {
        const fd = new FormData(document.form1);
        const trail_img = document.trails_form.trail_img;
        fetch('trails_upload.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (obj.success) {
                myimg.src = '<?= PROJ_ROOT ?>/trails_uploaded/' + obj.filename;
                trail_img.value = obj.filename;
                console.log(trail_img);
            }

        })

    };
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>