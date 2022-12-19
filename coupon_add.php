<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "coupon_add";
$title = "coupon_add";
?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>


<!-- add -->
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <h2>新增優惠卷</h2>
      <a href="./coupon_list.php" style="color: #fff;text-decoration:none;"><button type="button" class="btn btn-primary mb-1">優惠卷列表</button></a>
      <!-- <button type="button"><a href="./coupon_add.php">add</a></button> -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">新增資料</h5>

          <form name="form1" onsubmit="checkForm(event)" novalidate>
            <!-- 活動名稱先隱藏 -->
            <div class="mb-3 d-none">
              <label for="promo_name" class="form-label">活動名稱</label>
              <input type="text" class="form-control" id="promo_name" name="promo_name">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="coupon_name" class="form-label">優惠卷名稱</label>
              <input type="text" class="form-control" id="coupon_name" name="coupon_name">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="coupon_code" class="form-label">優惠碼</label>
              <input type="text" class="form-control" id="coupon_code" name="coupon_code">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="min_purchase" class="form-label">最低消費金額</label>
              <input type="text" class="form-control" id="min_purchase" name="min_purchase">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="coupon_rate" class="form-label">折數</label>
              <input type="text" class="form-control" id="coupon_rate" name="coupon_rate">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="start_date_coup" class="form-label">適用開始期限</label>
              <input type="datetime-local" class="form-control" id="start_date_coup" name="start_date_coup">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="end_date_coup" class="form-label">適用結束期限</label>
              <input type="datetime-local" class="form-control" id="end_date_coup" name="end_date_coup">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="coupon_status" class="form-label">優惠卷狀態</label>
              <select class="form-select" aria-label="Default select example" id="coupon_status" name="coupon_status">
                <option value="失效">失效</option>
                <option value="可使用">可使用</option>
              </select>
            </div>



            <button type="submit" class="btn btn-primary">新增</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/parts/scripts.php' ?>

<script>
  const checkForm = function(event) {
    // preventDefault 不以前端方式送出表單
    event.preventDefault();

    const fd = new FormData(document.form1);

    fetch('coupon_add_api.php', {
      method: 'POST',
      body: fd,
    }).then(r => r.json()).then(obj => {
      alert('新增成功');
      // location.href = 'coupon_list.php';
      // location.href = document.referrer;
      // 到最後一頁page?
      location.href ='coupon_list.php?page=10`';
    })
  };
</script>

<?php require __DIR__ . '/parts/html-foot.php' ?>
