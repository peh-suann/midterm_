<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "coupon";
$title = "coupon";

$perPage = 5; // 篩選頁數
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$t_sql = "SELECT COUNT(1) FROM coupon";
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
  // DESC
  // $sql = sprintf("SELECT * FROM `coupon` ORDER BY `sid` LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
  $sql = sprintf("SELECT `sid`, `promo_name`, `coupon_name`, `coupon_code`, `min_purchase`, `coupon_rate`, `start_date_coup`, `end_date_coup`, `coupon_status` FROM `coupon` WHERE `coupon_status`='可使用' AND `display`=1");
  $rows = $pdo->query($sql)->fetchAll();
}

?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>

<!-- couponlist -->
<div class="container">
  <!-- 功能選單 -->
  <div class="row">
    <div class="col">
      <h2>可使用優惠卷</h2>
      <!-- FIXME: -->
      <a href="./coupon_list.php" style="color: #fff;text-decoration:none;"><button type="button" class="btn btn-primary ms-1">優惠卷列表</button></a>
      <a href="./coupon_add.php" style="color: #fff;text-decoration:none;"><button type="button" class="btn btn-primary ms-1">新增優惠卷</button></a>
    </div>
  </div>

  <table name="coupon_list1" class="table table-striped table-bordered mt-1">
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
          <td><?= $r['coupon_rate'] ?></td>
          <td><?= $r['start_date_coup'] ?></td>
          <td><?= $r['end_date_coup'] ?></td>
          <td><?= $r['coupon_status'] ?></td>


          <td>
            <a href="coupon_edit.php?sid=<?= $r['sid'] ?>">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
          </td>
          <td>
            <a href="javascript: delete_it(<?= $r['sid'] ?>)">
              <i class="fa-solid fa-trash-can"></i>
            </a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>

  </table>
  <ul class="pagination" hidden>
    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
      <a class="page-link" href="?page=<?= $page == 1 ?>">
        <i class="fa-solid fa-angles-left"></i>
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
        <i class="fa-solid fa-angles-right"></i>
      </a>
    </li>
  </ul>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
  // const coupon1 = function() {

  //   fetch('coupon_add_api.php');
  // };

  // 刪除
  function delete_it(sid) {
    if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
      location.href = 'coupon_delete.php?sid=' + sid;
    }
  }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>