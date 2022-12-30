<?php require __DIR__ . '/parts/connect_db.php';
$pageName = "trails_add";
$title = "trails_add";

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

    .trails_card .trails_picture {
        background-color: #2894FF;
        width: 20%;
        border-radius: 10px;
        color: white;
        text-align: center;
    }
</style>

<div class="container">
    <div class="row">
        <div class="m-3">
            <a href="./trails.php" class="text-decoration-none" style="color:white;"><button type="button" class="btn btn-primary">返回商品</button></a>
        </div>
        <div class="trails_card">
            <div class="col-6 trails_add_card_body p-4">
                <h1 class="trails_add_card_title">新增商品</h1>
                <form name="form1" style="display:none;">
                    <input type="file" name="trail_image" accept="image/*" />
                </form>
                <form name="trailsform1" onsubmit="checkForm(event)">

                    <div class="mb-3">
                        <label for="name" class="form-label">名稱</label>
                        <input type="text" class="form-control" id="trail_name" name="trail_name" required>
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">圖片</label>
                    </div>
                    <div onclick="trail_image.click()" class="trails_picture p-2">上傳圖片</div>
                    <img id="myimg" src="" alt="" width="200px">
                    <input type="text" name="trail_img" value="" class="w-100 mb-2">

                    <label class="form-label me-2">描述</label>
                    <div class="mb-3 d-flex">
                        <textarea name="trail_describ" id="trail_describ" cols="100" rows="4" required></textarea>
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">簡述</label>
                        <input type="text" class="form-control" id="trail_short_describ" aria-describedby="emailHelp" name="trail_short_describ" required>
                        <div class="form-text"></div>
                    </div>

                    <label class="form-label me-2">行程規劃</label>
                    <div class="mb-3 d-flex">
                        <textarea name="trail_timetable" id="trail_timetable" cols="100" rows="4" required></textarea>
                        <div class="form-text"></div>
                    </div>

                    <label class="form-label">行程時長</label>
                    <div class="mb-3 d-flex">
                        <input type="number" class="form-control w-50" id="trail_time" aria-describedby="emailHelp" name="trail_time" required>
                        <div class="p-2">小時</div>
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-2">地理位置</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="geo_location_sid" id="geo_location_sid">
                        <option value="">請選擇縣市</option>
                        <option value="1">台北市</option>
                        <option value="2">新北市</option>
                        <option value="3">桃園市</option>
                        <option value="4">台中市</option>
                        <option value="5">台南市</option>
                        <option value="6">高雄市</option>
                        <option value="7">基隆市</option>
                        <option value="8">新竹市</option>
                        <option value="9">嘉義市</option>
                        <option value="10">新竹縣</option>
                        <option value="11">苗栗縣</option>
                        <option value="12">彰化縣</option>
                        <option value="13">南投縣</option>
                        <option value="14">雲林縣</option>
                        <option value="15">嘉義縣</option>
                        <option value="16">屏東縣</option>
                        <option value="17">宜蘭縣</option>
                        <option value="18">花蓮縣</option>
                        <option value="19">台東縣</option>
                        <option value="20">澎湖縣</option>
                        <div class="form-text"></div>
                    </select>

                    <div class="mb-2">難易度</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="difficulty_list_sid" id="difficulty_list_sid">
                        <option value="">請選擇難易度</option>
                        <option value="1">簡單</option>
                        <option value="2">中等</option>
                        <option value="3">困難</option>
                        <div class="form-text"></div>
                    </select>

                    <div class="mb-2">可否使用優惠券</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="coupon_status" id="coupon_status">
                        <option value="">請選擇可否使用優惠券</option>
                        <option value="1">可</option>
                        <option value="0">否</option>
                        <div class="form-text"></div>
                    </select>

                    <div class="mb-3">
                        <label class="form-label">價格</label>
                        <input type="text" class="form-control" id="price" aria-describedby="emailHelp" name="price" required>
                        <div class="form-text"></div>
                    </div>

                    <label class="form-label me-2">備註:</label>
                    <div class="mb-3 d-flex">
                        <textarea name="memo" id="memo" cols="100" rows="4"></textarea>
                        <div class="form-text"></div>
                    </div>

                    <label class="form-label me-2">裝備說明:</label>
                    <div class="mb-3 d-flex">
                        <textarea name="equipment" id="equipment" cols="100" rows="4"></textarea>
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-2">商品狀態</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="trails_display" id="trails_display">
                        <option value="">請選擇商品狀態</option>
                        <option value="1">已上架</option>
                        <option value="0">未上架</option>
                        <div class="form-text"></div>
                    </select>

                    <button type="submit" class="btn btn-primary">新增</button>
                </form>

            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
    const checkForm = function(event) {
        event.preventDefault();

        let isPass = true;
        // let field = document.trails_form.trail_name;
        // if (field.value.length < 2) {
        //     isPass = false;
        //     field.style.border = '2px solid red';
        //     field.nextElementSibling.innerHTML = '請輸入正確格式';
        // }

        // let field = document.trails_form.trail_describ;
        // if (field.value.length < 2) {
        //     isPass = false;
        //         field.style.border = '2px solid red';
        //         field.nextElementSibling.innerHTML = '請輸入正確格式';
        // }

        // let field = document.trails_form.trail_short_describ;
        // if (field.value.length < 2) {
        //     isPass = false;
        //         field.style.border = '2px solid red';
        //         field.nextElementSibling.innerHTML = '請輸入正確格式';
        // }

        if (isPass) {
            const fd = new FormData(document.trailsform1);

            fetch('trails_add_api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json()).then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('新增成功');
                    location.href = document.referrer;

                } else {
                    for (let id in obj.errors) {
                        const field1 = document.querySelector(`#${id}`);
                        field1.style.border = "2px solid red";
                        field1.closest('.mb-3').querySelector('.form-text').innerHTML = obj.errors[id];
                    }
                }
            })
        };

    };

    const trail_image = document.form1.trail_image;

    trail_image.onchange = function(event) {
        const fd = new FormData(document.form1);
        const trail_img = document.trailsform1.trail_img;
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