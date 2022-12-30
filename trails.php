<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "trails";
$title = "trails";
if (!isset($_SESSION)) {
    session_start();
}


$perPage = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($page < 1) {
    header('Location:?page=1');
    exit;
}

$trails_sql = "SELECT COUNT(1) FROM trails";

$trails_totalRows = $pdo->query($trails_sql)->fetch(PDO::FETCH_NUM)[0];
$trails_totalPages = ceil($trails_totalRows / $perPage);

$trails_rows = [];
if ($trails_totalRows > 0) {

    if ($page > $trails_totalPages) {
        header('Location:?page=' . $trails_totalPages);
        exit;
    }

    $sql = sprintf("SELECT * FROM `trails` LIMIT %s,%s", ($page - 1) * $perPage, $perPage);

    $trails_rows = $pdo->query($sql)->fetchAll();
}

// $isPass = false;

// if ($isPass) {
//     if (isset($_GET['trail_select'])) {
//         $isPass = true;

//         if ($_GET['trail_select'] == '否')

//             $perPage = 5;
//         $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//         if ($page < 1) {
//             header('Location:?page=1');
//             exit;
//         }

//         $trails_sql = "SELECT COUNT(1) FROM trails";

//         $trails_totalRows = $pdo->query($trails_sql)->fetch(PDO::FETCH_NUM)[0];
//         $trails_totalPages = ceil($trails_totalRows / $perPage);



//         $sql_select = "SELECT `sid` FROM `trails` WHERE  `coupon_status`='0'";
//         $stmt_select = $pdo->query($sql_select)->fetchAll();
//     }
// }



?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>

<div class="d-flex flex-column w-100">
    <h1 class="p-2 mx-3">商品管理</h1>
    <div class="d-flex justify-content-start p-2 mx-3">
        <div>
            <a href="./trails.php" class="text-decoration-none" style="color:white;"><button type="button"
                    class="btn btn-primary">商品管理</button></a>
            <a href="./trails_add.php" class="text-decoration-none" style="color:white;"><button type="button"
                    class="btn btn-primary">新增</button></a>
            <!-- <a href="./trails_display1.php" class="text-decoration-none" style="color:white;"><button type="button"
                    class="btn btn-primary">一鍵上架</button></a> -->
        </div>

        <!-- <div class="w-50 ms-2">
            <form action="" method="get" enctype="multipart/form-data">
                <div class="mb-3 d-flex">
                    <input type="search" class="form-control" id="trail_select" name="trail_select">
                    <div class="form-text"></div>
                    <button type="submit" class="btn btn-primary w-25 ms-2">搜尋</button>
                </div>

            </form>
        </div> -->

        <!-- <div class="d-flex">
            <select class="form-select" aria-label="Default select example">
                <option value="" selected>請選擇條件</option>
                <option value="<?= $trails_rows['coupon_status'] == 1 ?>">可使用折價券</option>
                <option value="<?= $trails_rows['coupon_status'] == 0 ?>">不可使用折價券</option>

            </select>
            <button type="button" class="btn btn-primary "><a href="./trails_select.php" class="text-decoration-none"
                    style="color:white;">搜尋</a></button>
        </div> -->


    </div>
    <table class="table table-striped">
        <thead>

            <tr>
                <th class="text-center align-middle">
                    <i class="fa-solid fa-trash-can"></i>
                </th>
                <th class="text-center align-middle">
                    <i class="fa-solid fa-file-pen"></i>
                </th>
                <!-- <th class="justify-content-center align-middle">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                    </div>
                </th> -->
                <th class="text-center align-middle">#</th>
                <th class="col-2 text-center align-middle">名稱
                <th class="col-2 text-center align-middle">簡述
                <th class="col-2 text-center align-middle">可否使用優惠碼</th>
                <th class="col-1 text-center align-middle">價格</th>
                <th class="col text-center align-middle">商品狀態</th>
                <th class="col text-center align-middle">詳細資料</th>
            </tr>

        </thead>
        <tbody>
            <?php foreach ($trails_rows as $t_r) : ?>
            <tr>
                <td class="text-center align-middle">
                    <a href="javascript: trails_delete_it(<?= $t_r['sid'] ?>)">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="trails_qa(<?= $t_r['sid'] ?>)">
                            <i class="fa-solid fa-trash-can"></i>
                        </button> -->



                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        id="trails_qa(<?= $t_r['sid'] ?>)">
                        <i class="fa-solid fa-trash-can"></i>
                    </button> -->
                    <!-- Modal -->
                    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">是否要刪除這筆資料
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary tem">暫時刪除</button>
                                    <button type="button" class="btn btn-primary forever">永久刪除</button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </td>
                <td class="text-center align-middle">
                    <a href="trails_edit.php?sid=<?= $t_r['sid'] ?>">
                        <i class="fa-solid fa-file-pen"></i>
                    </a>
                </td>
                <!-- <th class="justify-content-center align-middle">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                    </div>
                </th> -->
                <td class="text-center align-middle"><?= $t_r['sid'] ?></td>
                <td class="col-2 text-center align-middle"><?= htmlentities($t_r['trail_name']) ?></td>
                <td class="col-2 text-center align-middle"><?= htmlentities($t_r['trail_short_describ']) ?></td>
                <td class="col-2 text-center align-middle">
                    <?php if ($t_r['coupon_status'] == 0) {
                            echo '否';
                        } else {
                            echo '是';
                        } ?>
                </td>

                <td class="col-1 text-center align-middle"><?= htmlentities($t_r['price']) ?></td>
                <td class="col-1 text-center align-middle">
                    <?php if ($t_r['trails_display'] == 0) {
                            echo '<div style="background-color:#EA0000; border-radius: 10px;" class="p-2">未上架</div>';
                        } else {
                            echo '<div style="background-color:#02DF82; border-radius: 10px;" class="p-2">已上架</div>';
                        } ?>
                </td>
                <!-- <div style="background-color:red;" class="p-3">未上架</div> -->
                <td class="col text-center align-middle"> <a href="./trails_detail.php?sid=<?= $t_r['sid'] ?>"
                        class="text-decoration-none" style="color:white;"><button type="button"
                            class="btn btn-primary">詳細資料</button></a></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example" class="d-flex justify-content-start   align-items-center m-4">
        <ul class="pagination justify-content-end">
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=1">第一頁</a>
            </li>
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) : ?>
            <?php if ($i >= 1 and $i <= $trails_totalPages) : ?>
            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php
                endif;
            endfor; ?>
            <li class="page-item <?= $page == $trails_totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $trails_totalPages ?>">最後一頁</a>
                <!-- <div>id="product< $rows[sid] >"</div> //導師範例-->
            </li>
        </ul>
    </nav>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
function trails_delete_it(sid) {
    if (confirm(`是否要刪除 ${sid} 這筆資料?`)) {
        location.href = 'trails_delete.php?sid=' + sid;
    }
}



//可以隱藏但網頁更新會跑出來
// const tbody = document.querySelector('tbody');       
// tbody.addEventListener('click', function(event) {
//     const t = event.target;
//     if (t.classList.contains('fake')) {
//         t.closest('tr').style.display = "none";
//     };
// });










// const sid = document.querySelector('#trails_qa(${sid})');

// function trails_qa(sid) {
//     const eddie = document.getElementById(`product${sid}`)   //導師範例

//     const tem = document.querySelector('#tem');
//     const forever = document.querySelector('#forever');

//     if (tem) {
//         tem.onclick = sid.style.display = "none";
//     }
//     if (forever) {
//         forever.onclick = location.href = 'trails_delete.php?sid=' + sid;
//     }


// }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>