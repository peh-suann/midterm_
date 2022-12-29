<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "coupon";
$title = "coupon";
if (!isset($_SESSION)) {
  session_start();
}

$perPage = 5; // 每一頁最多有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$t_sql = "SELECT COUNT(1) FROM coupon WHERE `display`=1";
// 取得總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
// 總頁數
$totalPages = ceil($totalRows / $perPage);


$rows = []; // 資料
if ($totalRows > 0) {
  if ($page > $totalPages) {
    header('Location: ?page=' . $totalPages);
    exit;
  }
  // 折數的篩選
  if (isset($_GET["coupon_rate"])) {
    $coupon_rate = $_GET["coupon_rate"];
    $sql = "SELECT * FROM `coupon`  WHERE `coupon_rate`=$coupon_rate AND `display`=1";
    // 取空值(未選擇)會跳錯，所以值>0
    if ($coupon_rate > 0) {
      $rows = $pdo->query($sql)->fetchAll();
    }
  } else {
    $sql = sprintf("SELECT * FROM `coupon` WHERE `display`=1 ORDER BY `sid` LIMIT %s, %s ", ($page - 1) * $perPage, $perPage);

    $rows = $pdo->query($sql)->fetchAll();
  }
}

$rateArr = [];
foreach ($rows as $coupon_rate) {
  $rateArr[$coupon_rate['coupon_rate']] = $coupon_rate['coupon_rate'];
}



header('application/json');
$text_sql = "SELECT `sid`,`start_date_coup`,`end_date_coup`,`coupon_status` FROM `coupon` WHERE `sid`";
$t_s = $pdo->query($text_sql)->fetchAll();



?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<style>
</style>
<?php require __DIR__ . '/parts/navbar.php' ?>

<!-- couponlist -->
<div class="container">
  <!-- 功能選單 -->
  <div class="row">
    <div class="col">
      <h2>優惠卷列表</h2>

      <!-- filter:篩選coupon_rate -->

      <form class="input-group  mb-1" action="coupon_list.php" method="get" class="">
        <a href="./coupon_list.php" style="color: #fff;text-decoration:none;"><button type="button" class="btn btn-primary ms-1">返回優惠卷列表</button></a>
        <a href="./coupon_add.php" style="color: #fff;text-decoration:none;"><button type="button" class="btn btn-primary ms-1">新增優惠卷</button></a>
        <a href="./coupon_list_filter1.php" style="color: #fff;text-decoration:none;"><button type="button" class="btn btn-primary ms-1">可使用</button></a>
        <select name="coupon_rate" id="coupon_rate" class="col-4 ms-1" placeholder="選擇折數">
          <option value="">選擇折數</option>
          <option value="95">95折</option>
          <option value="9">9折</option>
          <option value="85">85折</option>
          <option value="8">8折</option>
          <option value="7">7折</option>
          <option value="6">6折</option>
          <option value="5">5折</option>

          <!-- 抓的折數會重複 -->
          <? #php foreach ($rows as $coupon_rate) : 
          ?>
          <!-- <option value="<? #= $coupon_rate["coupon_rate"] 
                              ?>"><? #= $coupon_rate["coupon_rate"] 
                                  ?></option> -->
          <? #php endforeach 
          ?>
        </select>
        <button type="submit" class="btn btn-primary ms-1">篩選</button>
      </form>



    </div>
  </div>

  <table name="coupon_list1" class=" table table-striped table-bordered ">
    <thead>
      <tr>
        <th scope="col">#</th>
        <!-- <th scope="col">活動名稱</th> -->
        <th scope="col">優惠卷名稱</th>
        <th scope="col">優惠碼</th>
        <th scope="col">最低消費金額</th>
        <th scope="col">折數</th>
        <th scope="col">適用開始期限</th>
        <th scope="col">適用結束期限</th>
        <th scope="col">優惠卷狀態</th>

        <th scope="col">
          <i class="fa-solid fa-pen-to-square"></i>
        </th>
        <th scope="col">
          <i class="fa-solid fa-trash-can"></i>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r) : ?>

        <tr>
          <td><?= $r['sid'] ?></td>
          <!-- <td><? #= $r['promo_name'] 
                    ?></td> -->
          <td><?= $r['coupon_name'] ?></td>
          <td><?= $r['coupon_code'] ?></td>
          <td><?= $r['min_purchase'] ?></td>
          <!-- <td><? #= $r['coupon_rate'] 
                    ?></td> -->
          <td><?= $rateArr[$r["coupon_rate"]] ?></td>
          <td><?= $r['start_date_coup'] ?></td>
          <td><?= $r['end_date_coup'] ?></td>
          <!-- FIXME:以end_date_coup判斷是否過期 -->
          <!-- <td><? #= $r['coupon_status'] 
                    ?></td> -->


          <td><?php if ($r['end_date_coup'] > date("Y-m-d H:i:s") and $r['start_date_coup'] < date("Y-m-d H:i:s")) {
                echo '可使用';
              } else {
                echo '已失效';
              }
              ?></td>


          <td>

            <a href="coupon_edit.php?sid=<?= $r['sid'] ?>">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
          </td>
          <td>
            <a>
              <i class="fa-solid fa-trash-can text-secondary" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="delete_it(<?= $r['sid'] ?>)"></i>
              <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteModalLabel">刪除資料</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                      <a id="fake-delete" style="color: #fff;text-decoration:none;" href="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">列表中刪除</button>
                      </a>
                      <a id="delete" style="color: #fff;text-decoration:none;" href="">
                        <button type="button" class="btn btn-danger">永久刪除</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>

  </table>
  <ul class="pagination">
    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
      <a class="page-link" href="?page=<?= $page == 1 ?>">
        <i>第一頁</i>
      </a>
    </li>
    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
      if ($i >= 1 and $i <= $totalPages) :
    ?>
        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
    <?php
      endif;
    endfor; ?>
    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
      <a class="page-link" href="?page=<?= $page += $totalPages ?>">
        <i>最後一頁</i>
      </a>
    </li>
  </ul>
</div>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
  // 刪除
  // function delete_it(sid) {
  //   if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
  //     location.href = 'coupon_delete.php?sid=' + sid;
  //   }
  // }
  // FIXME:
  function delete_it(sid) {
    const fakedelete = document.querySelector('#fake-delete');
    console.log(fakedelete);
    fakedelete.href = `conpon_fake_delete.php?sid=${sid}`;
    // 永久刪除
    const mdelete = document.querySelector('#delete');
    mdelete.href = `coupon_delete.php?sid=${sid}`;
  }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>