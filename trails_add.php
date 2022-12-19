<?php require __DIR__ . '/parts/connect_db.php';
$pageName = "trrails_add";
$title = "trrails_add";

?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>

<div class="container">
    <div class="row">
        <div class="m-3">
           <a href="./trails.php" class="text-decoration-none" style="color:white;"><button type="button"
                    class="btn btn-primary">返回商品</button></a>
        </div>
        <div class="trails_card">
            <div class="col-6 trails_add_card_body p-4">
                <h1 class="trails_add_card_title">新增商品</h1>
                <form name="trailsform1" onsubmit="checkForm(event)">

                    <div class="mb-3">
                        <label for="name" class="form-label">名稱</label>
                        <input type="text" class="form-control" id="trail_name" name="trail_name">
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">圖片</label>
                        <input type="text" class="form-control" id="trail_img" aria-describedby="emailHelp"
                            name="trail_img">
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">描述</label>
                        <input type="text" class="form-control" id="trail_describ" aria-describedby="emailHelp"
                            name="trail_describ">
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">簡述</label>
                        <input type="text" class="form-control" id="trail_short_describ" aria-describedby="emailHelp"
                            name="trail_short_describ">
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">行程規劃</label>
                        <input type="text" class="form-control" id="trail_timetable" aria-describedby="emailHelp"
                            name="trail_timetable">
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">行程時長</label>
                        <input type="text" class="form-control" id="trail_time" aria-describedby="emailHelp"
                            name="trail_time">
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-2">地理位置</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="geo_location_sid"
                        id="geo_location_sid">
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
                    <select class="form-select mb-3" aria-label="Default select example" name="difficulty_list_sid"
                        id="difficulty_list_sid">
                        <option value="">請選擇難易度</option>
                        <option value="1">簡單</option>
                        <option value="2">中等</option>
                        <option value="3">困難</option>
                        <div class="form-text"></div>
                    </select>

                    <div class="mb-2">可否使用優惠券</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="coupon_status"
                        id="coupon_status">
                        <option value="">請選擇可否使用優惠券</option>
                        <option value="1">可</option>
                        <option value="0">否</option>
                        <div class="form-text"></div>
                    </select>

                    <div class="mb-3">
                        <label class="form-label">價格</label>
                        <input type="text" class="form-control" id="price" aria-describedby="emailHelp" name="price">
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3 d-flex">
                        <label class="form-label me-2">備註:</label>
                        <textarea name="memo" id="memo" cols="100" rows="4"></textarea>
                        <div class="form-text"></div>
                    </div>

                    <div class="mb-3 d-flex">
                        <label class="form-label me-2">裝備說明:</label>
                        <textarea name="equipment" id="equipment" cols="100" rows="4"></textarea>
                        <div class="form-text"></div>
                    </div>
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
            }
            //  else {
            //     for (let id in obj.errors) {
            //         const field = document.querySelector(`#${id}`);
            //         field.style.border = '2px solid red';
            //                 field.closest('.mb-3').querySelector('.form-text').innerHTML = obj.errors[id];
            //             }
            //     }
        })
    };

};
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>
