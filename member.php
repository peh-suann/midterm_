<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "member";
$title = "member";


$perPage = 10; // 每一頁最多有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$t_member = "SELECT COUNT(1) FROM `member` WHERE `display`=1";
$total_member = $pdo->query($t_member)->fetch(PDO::FETCH_NUM)[0];
// echo $total_member;
$totalPage = ceil($total_member / $perPage);

// 取出資料庫的資料
$rows = [];
$sql = sprintf("SELECT * FROM `member` WHERE `display`=1 ORDER BY `sid` DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
$rows = $pdo->query($sql)->fetchAll();


?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>


<div class="container">
    <div class="mt-3 row align-items-center justify-content-between">
        <h2 class="col-8">會員管理</h2>
        <div class="col-2">
            <button style="line-height: 1.0;" type="button" class="btn btn-info">
                <a style="color: #fff;text-decoration:none;" href="member_add.php">新增會員</a>
            </button>
        </div>
    </div>
    <!-- 篩選選單 -->
    <div class="row mt-3">
        <div class="col">
            <form class="input-group" method="get">
                <div class="form-outline">
                    <input type="search" id="accountq" name="accountq" class="form-control" placeholder="依帳號篩選" />
                </div>
                <div class="form-outline ms-1">
                    <input type="search" id="mobileq" name="mobileq" class="form-control" placeholder="依手機篩選" />
                </div>
                <select class="ms-1" name="statusq" id="statusq" placeholder="依狀態篩選">
                    <option value="">依狀態篩選</option>
                    <option value="1">使用中</option>
                    <option value="0">已停權</option>
                </select>



                <!-- <a id="searchIcon" href=""> -->
                <button type="submit" class="btn btn-primary ms-1">
                    送出
                </button>
                <!-- </a> -->
            </form>
        </div>
    </div>

    <?php
    // 判斷是否有篩選
    $isSelect = false;
    if ((isset($_GET['accountq']) and strlen($_GET['accountq']) > 0) or (isset($_GET['statusq']) and strlen($_GET['statusq']) > 0) or (isset($_GET['mobileq']) and strlen($_GET['mobileq']) > 0)) {
        $isSelect = true;
    }

    if ($isSelect) {
        if (isset($_GET['accountq']) and strlen($_GET['accountq']) > 0) {

            $perPage = 10; // 每一頁最多有幾筆
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

            // 搜尋keywords
            $searchKey = isset($_GET['accountq']) ? ($_GET['accountq']) : '';


            // 計算總頁數
            $t_member = "SELECT COUNT(1) FROM `member` WHERE `account` LIKE '%$searchKey%' AND `display`=1";
            $total_member = $pdo->query($t_member)->fetch(PDO::FETCH_NUM)[0];
            $totalPage = ceil($total_member / $perPage);


            // 取出資料庫的資料
            $first = ($page - 1) * $perPage;
            $last = $perPage;

            $rows = [];
            $sql = "SELECT * FROM `member` WHERE `account` LIKE '%$searchKey%' AND `display`=1 ORDER BY `sid` DESC LIMIT $first, $last";
            $rows = $pdo->query($sql)->fetchAll();

    ?>

    <div class="row">
        <div class="col">
            共<?= $total_member ?>筆
        </div>
    </div>
    <?php
        }

        if (isset($_GET['statusq']) and strlen($_GET['statusq']) > 0) {

            $perPage = 10; // 每一頁最多有幾筆
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

            // 搜尋keywords
            $searchKey = isset($_GET['statusq']) ? ($_GET['statusq']) : '';


            // 計算總頁數
            $t_member = "SELECT COUNT(1) FROM `member` WHERE `member_status`=$searchKey AND `display`=1";
            $total_member = $pdo->query($t_member)->fetch(PDO::FETCH_NUM)[0];
            $totalPage = ceil($total_member / $perPage);


            // 取出資料庫的資料
            $first = ($page - 1) * $perPage;
            $last = $perPage;

            $rows = [];
            $sql = "SELECT * FROM `member` WHERE `member_status`=$searchKey AND `display`=1 ORDER BY `sid` DESC LIMIT $first, $last";
            $rows = $pdo->query($sql)->fetchAll(); ?>

    <div class="row">
        <div class="col">
            共<?= $total_member ?>筆
        </div>
    </div>
    <?php
        }

        if (isset($_GET['mobileq']) and strlen($_GET['mobileq']) > 0) {

            $perPage = 10; // 每一頁最多有幾筆
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

            // 搜尋keywords
            $searchKey = isset($_GET['mobileq']) ? ($_GET['mobileq']) : '';


            // 計算總頁數
            $t_member = "SELECT COUNT(1) FROM `member` WHERE `mobile` LIKE '%$searchKey%' AND `display`=1";
            $total_member = $pdo->query($t_member)->fetch(PDO::FETCH_NUM)[0];
            $totalPage = ceil($total_member / $perPage);


            // 取出資料庫的資料
            $first = ($page - 1) * $perPage;
            $last = $perPage;

            $rows = [];
            $sql = "SELECT * FROM `member` WHERE `mobile` LIKE '%$searchKey%' AND `display`=1 ORDER BY `sid` DESC LIMIT $first, $last";
            $rows = $pdo->query($sql)->fetchAll();

        ?>

    <div class="row">
        <div class="col">
            共<?= $total_member ?>筆
        </div>
    </div>
    <?php
        }
    }
    ?>




    <!-- member list -->
    <div class="row mt-3">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>

                        <th scope="col">#</th>
                        <th scope="col">帳號</th>
                        <th scope="col">姓名</th>
                        <th scope="col">手機</th>
                        <th scope="col">使用者狀態</th>
                        <th scope="col">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>
                        <th scope="col">詳細資料</th>

                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($rows as $r) : ?>
                    <tr>
                        <th scope="row"><?= $r['sid'] ?></th>
                        <td><?= $r['account'] ?></td>
                        <td><?= $r['name'] ?></td>
                        <td><?= $r['mobile'] ?></td>
                        <?php if ($r['member_status']) : ?>
                        <td class="text-success"><?= "使用中" ?></td>
                        <?php else : ?>
                        <td class="text-danger"><?= "已停權" ?></td>
                        <?php endif; ?>
                        <td>
                            <a href="member_edit.php?sid=<?= $r['sid'] ?>">
                                <i class="fa-solid fa-pen-to-square text-secondary"></i>
                            </a>
                        </td>
                        <td>
                            <a>
                                <i class="fa-solid fa-trash-can text-secondary" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" onclick="delete_it(<?= $r['sid'] ?>)"></i>
                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal" tabindex="-1"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">刪除資料</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <a id="fake-delete" style="color: #fff;text-decoration:none;"
                                                        href="">暫時刪除</a>
                                                </button>
                                                <button type="button" class="btn btn-danger">
                                                    <a id="delete" style="color: #fff;text-decoration:none;"
                                                        href="">永久刪除</a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td>
                            <button style="line-height: 1.0;" type="button" class="btn btn-primary">
                                <a style="color: #fff;text-decoration:none;"
                                    href="member_detail.php?sid=<?= $r['sid'] ?>">詳細資料</a>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- pagination  -->
    <div class="row justify-content-between">
        <div class="col-8">
            <nav style=<?= ($totalPage > 1) ? "" : "display:none;" ?> aria-label="Page navigation example">
                <ul class="pagination">

                    <!--  pagination 第一頁 -->
                    <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                        <?php $params['page']   = 1;
                        $new_query_string = http_build_query($params);
                        if ($isSelect) :
                            if (!strpos($_SERVER['REQUEST_URI'], "page")) :
                        ?>
                        <a class="page-link" href="<?= $_SERVER['REQUEST_URI'] . '&' . $new_query_string ?>"
                            aria-label="Previous">
                            第一頁
                        </a>
                        <?php else :
                                $query = explode('?', $_SERVER['REQUEST_URI']);
                                parse_str($query[1], $data);
                                $data['page'] = 1;
                            ?>
                        <a class="page-link" href="<?= $query[0] . '?' . http_build_query($data); ?>"
                            aria-label="Previous">
                            第一頁
                        </a>
                        <?php endif; ?>
                        <?php else : ?>
                        <a class="page-link" href="?page=1" aria-label="Previous">
                            第一頁
                        </a>
                        <?php endif; ?>
                    </li>


                    <!--  pagination 中間頁碼 -->
                    <?php for ($i = $page - 3; $i <= $page + 3; $i++) :
                        if ($i >= 1 and $i <= $totalPage) :
                    ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <?php if ($isSelect) :
                                    $params['page']   = $i;
                                    $new_query_string = http_build_query($params);
                                    if (!strpos($_SERVER['REQUEST_URI'], "page")) :
                                ?>
                        <a class="page-link" href="<?= $_SERVER['REQUEST_URI'] . '&' . $new_query_string ?>"><?= $i ?>
                        </a>
                        <?php else :
                                        $query = explode('?', $_SERVER['REQUEST_URI']);
                                        parse_str($query[1], $data);
                                        $data['page'] = $i;
                                    ?>
                        <a class="page-link" href="<?= $query[0] . '?' . http_build_query($data); ?>"><?= $i ?>
                        </a>
                        <?php endif; ?>
                        <?php else : ?>
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?>
                        </a>
                        <?php endif; ?>
                    </li>
                    <?php endif;
                    endfor; ?>

                    <!--  pagination 最後一頁 -->
                    <li class="page-item <?= ($page == $totalPage) ? 'disabled' : '' ?>">
                        <?php $params['page']   = $totalPage;
                        $new_query_string = http_build_query($params);
                        if ($isSelect) :
                            if (!strpos($_SERVER['REQUEST_URI'], "page")) :
                        ?>
                        <a class="page-link" href="<?= $_SERVER['REQUEST_URI'] . '&' . $new_query_string ?>"
                            aria-label="Previous">
                            最後一頁
                        </a>
                        <?php else :
                                $query = explode('?', $_SERVER['REQUEST_URI']);
                                parse_str($query[1], $data);
                                $data['page'] = $totalPage;
                            ?>
                        <a class="page-link" href="<?= $query[0] . '?' . http_build_query($data); ?>"
                            aria-label="Previous">
                            最後一頁
                        </a>
                        <?php endif; ?>
                        <?php else : ?>
                        <a class="page-link" href="?page=<?= $totalPage ?>" aria-label="Previous">
                            最後一頁
                        </a>
                        <?php endif; ?>
                    </li>




                </ul>
            </nav>
        </div>
        <div class="col-2">
            <?php
            if ($isSelect) :
            ?>
            <button style="line-height: 1.0;" type="button" class="btn btn-secondary">
                <a style="color: #fff;text-decoration:none;" href="member.php">回列表頁</a>
            </button>
            <?php endif;
            ?>
        </div>
    </div>


</div>



<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
function delete_it(sid) {
    const fakedelete = document.querySelector('#fake-delete');
    console.log(fakedelete);
    fakedelete.href = `member_fake-delete.php?sid=${sid}`;
    const mdelete = document.querySelector('#delete');
    mdelete.href = `member_delete.php?sid=${sid}`;
}

// function dosearch() {
//     const searchIcon = document.querySelector('#searchIcon');
//     searchIcon.href = "member.php?q=" + escape(document.querySelector('#form1').value);
// }
</script>
</script>

<?php require __DIR__ . '/parts/html-foot.php' ?>