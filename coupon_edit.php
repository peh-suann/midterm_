<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "coupon_edit";
$title = "coupon_edit";

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
  header('Location: coupon_list.php'); // 轉向到列表頁
  exit;
}

$sql = "SELECT * FROM coupon WHERE sid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
  header('Location: coupon_list.php'); // 轉向到列表頁
  exit;
}

?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>



<!-- add -->
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <h2>編輯優惠卷</h2>
      <a href="./coupon_list.php" style="color: #fff;text-decoration:none;"><button type="button" class="btn btn-primary mb-1">優惠卷列表</button></a>
      <a href="./coupon_add.php" style="color: #fff;text-decoration:none;"><button type="button" class="btn btn-primary mb-1">新增優惠卷</button></a>
      <div class="card">
        <div class="card-body">

          <form name="form1" onsubmit="checkForm(event)" 　>

            <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
            <!-- 活動名稱先隱藏 -->
            <!-- <div class="mb-3 " >
              <label for="promo_name" class="form-label" >活動名稱</label>
              <input type="text" class="form-control" id="promo_name" name="promo_name" required value="<? #= $r['promo_name'] 
                                                                                                        ?>">
              <div class="form-text"></div>
            </div> -->

            <div class="mb-3">
              <label for="coupon_name" class="form-label">優惠卷名稱*</label>
              <input type="text" class="form-control" id="coupon_name" name="coupon_name" value="<?= $r['coupon_name'] ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="coupon_code" class="form-label">優惠碼*</label>
              <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="<?= $r['coupon_code']
                                                                                                  ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="min_purchase" class="form-label">最低消費金額*</label>
              <input type="text" class="form-control" id="min_purchase" name="min_purchase" value="<?= $r['min_purchase']
                                                                                                    ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="coupon_rate" class="form-label">折數*</label>
              <input type="text" class="form-control" id="coupon_rate" name="coupon_rate" value="<?= $r['coupon_rate']
                                                                                                  ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="start_date_coup" class="form-label">適用開始期限*</label>
              <input type="datetime-local" class="form-control" id="start_date_coup" name="start_date_coup" value="<?= $r['start_date_coup'] ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="end_date_coup" class="form-label">適用結束期限*</label>
              <input type="datetime-local" class="form-control" id="end_date_coup" name="end_date_coup" value="<?= $r['end_date_coup'] ?>">
              <div class="form-text"></div>
            </div>
            <!-- <div class="mb-3">
              <label for="coupon_status" class="form-label">優惠卷狀態</label>
              <select class="form-select" aria-label="Default select example" id="coupon_status" name="coupon_status">

                FIXME:toggle coupon status
                <option value="">可否使用優惠卷</option>
                <option value="可使用" <? #= $r['coupon_status'] == "可使用" ? 'selected' : ''
                                    ?>>可使用</option>
                <option value="已失效" <? #= $r['coupon_status'] == "已失效" ? 'selected' : ''
                                    ?>>已失效</option>
              </select>
            </div> -->


            <div class="alert alert-primary" role="alert" id="myAlert" style="display: none;"></div>
            <button type="submit" class="btn btn-primary">修改</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/parts/scripts.php' ?>

<script>
  const rowData = <?= json_encode($r, JSON_UNESCAPED_UNICODE) ?>;

  const myAlert = document.querySelector('#myAlert');
  const showAlert = function(msg = '沒給訊息文字', type = 'primary') {
    myAlert.innerHTML = msg;
    myAlert.className = `alert alert-${type}`;
    myAlert.style.display = 'block';
  }
  const hideAlert = function() {
    myAlert.style.display = 'none';
  }

  const checkForm = function(event) {
    event.preventDefault();

    const fd = new FormData(document.form1);

    fetch('coupon_edit_api.php', {

      method: 'POST',
      body: fd,
    }).then(r => r.json()).then(obj => {
      console.log(obj);
      if (obj.success) {
        console.log(obj.success);
        alert('修改成功');
        // location.href = 'coupon_list.php';
        // history.back();
        // 回到上一頁，並刷新
        location.href = document.referrer;
      } else {
        for (let id in obj.errors) {
          const field = document.querySelector(`#${id}`);
          // console.log(field);
          field.style.border = '2px solid red';
          field.closest('.mb-3').querySelector('.form-text').innerHTML = obj.errors[id];
          // field.nextElementSibling.innerHTML = obj.errors[id];
        }
      }
    })

  }
</script>

<?php require __DIR__ . '/parts/html-foot.php' ?>