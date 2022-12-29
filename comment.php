<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "評論管理";
$title = "評論管理";
if (!isset($_SESSION)) {
    session_start();
}

//列表控制

$perPage = 10; //每一頁的最高筆數
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM `rating`";
//取得總比數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
//總頁數
$totalPages = ceil($totalRows / $perPage);

$rows = [];
$rows_sql = "SELECT * FROM `rating` WHERE 1";
$sql = sprintf("SELECT * FROM `rating` ORDER BY `sid` ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
$rows = $pdo->query($sql)->fetchAll();

$member_rows = [];
$member_rows_sql = "SELECT `sid`, `name` FROM `member` WHERE 1";
$member_rows = $pdo->query($member_rows_sql)->fetchAll();

$trail_rows = [];
$trail_rows_sql = "SELECT `sid`, `trail_name` FROM `trails` WHERE 1";
$trail_rows = $pdo->query($trail_rows_sql)->fetchAll();


if ($totalRows > 0) {
    if ($page > $totalPages) {
        header('location: ?page=' . $totalPages);
        exit;
    }
}

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
// if (empty($sid)) {
//     // header('Location: comment.php');

// }

//編輯評論用 fetch
$sql_edit = "SELECT * FROM `rating` WHERE sid=$sid";
$r = $pdo->query($sql_edit)->fetch();
// if (empty($r)) {
//     header('Location: comment.php');
//     exit;
// }
?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>
<div class="container">
    <div class="row">
        <h2>評論管理</h2>
        <div class="col-12 d-flex justify-content-between">
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= PROJ_ROOT ?>/index_.php">後台首頁</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="<?= PROJ_ROOT ?>/comment.php">評論管理</a></li>
                    <!-- <li class="breadcrumb-item active" aria-current="page">Data</li> -->
                </ol>
            </nav>
            <!-- 新增評論按鈕 -->
            <a style="text-decoration:none;" href="comment_add.php">
                <button style="color: #fff;line-height: 1.0;" type="button" class="btn btn-info">新增評論</button>
            </a>
        </div>


        <!-- 篩選功能欄位 -->
        <div class="d-flex justify-content-between align-item-center">
            <div class="row ">
                <div class="col">
                    <form class="input-group" method="get">
                        <!-- <div class="form-outline">
                            <input type="search" id="accountq" name="accountq" class="form-control" placeholder="依評論人篩選" />
                        </div> -->
                        <select class="ms-1" name="scoreq" id="scoreq" placeholder="依評分篩選">
                            <option value="">依評分篩選</option>
                            <option value="5">五星評論</option>
                            <option value="4">四星評論</option>
                            <option value="3">三星評論</option>
                            <option value="2">二星評論</option>
                            <option value="1">一星評論</option>
                        </select>
                        <select class="ms-1" name="statusq" id="statusq" placeholder="依狀態篩選">
                            <option value="">依狀態篩選</option>
                            <option value="1">已回覆</option>
                            <option value="0">未回覆</option>
                        </select>

                        <!-- <a id="searchIcon" href=""> -->
                        <button type="submit" class="btn btn-primary ms-1">
                            送出
                        </button>
                        <!-- </a> -->
                    </form>
                </div>
            </div>
        </div>
        <?php
        $isSelect = false;
        //判斷是否有篩選
        if ((isset($_GET['accountq']) and strlen($_GET['accountq']) > 0) or (isset($_GET['statusq']) and strlen($_GET['statusq']) > 0) or (isset($_GET['scoreq']) and strlen($_GET['scoreq']) > 0)) {
            $isSelect = true;
        }
        //有下篩選的話要怎麼呈現？
        if ($isSelect) {
            //篩選人名字
            if (isset($_GET['accountq']) and strlen($_GET['accountq']) > 0) {
                //搜尋後的頁面排列
                $perPage = 10; // 每一頁最多有幾筆
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                //設定搜尋keyword
                $searchKey = isset($_GET['accountq']) ? ($_GET['accountq']) : '';
                //計算總頁數
                $t_member = "SELECT COUNT(1) FROM `rating` WHERE `person` LIKE '%$searchKey%' AND `display`=1";
                $total_member = $pdo->query($t_member)->fetch(PDO::FETCH_NUM)[0];
                $totalPage = ceil($total_member / $perPage);
                //取出資料庫的資料
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
            //篩選人評分
            if (isset($_GET['scoreq']) and strlen($_GET['scoreq']) > 0) {
                //搜尋後的頁面排列
                $perPage = 10; // 每一頁最多有幾筆
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                //searchkey
                $searchKey = isset($_GET['scoreq']) ? ($_GET['scoreq']) : '';
                //計算總頁數
                $t_member = "SELECT COUNT(1) FROM `rating` WHERE `score` LIKE '%$searchKey%' ";
                $total_member = $pdo->query($t_member)->fetch(PDO::FETCH_NUM)[0];
                $totalPage = ceil($total_member / $perPage);
                //取出資料庫的資料
                $first = ($page - 1) * $perPage;
                $last = $perPage;

                $rows = [];
                $sql = "SELECT * FROM `rating` WHERE `score` LIKE '%$searchKey%'  ORDER BY `sid` ASC LIMIT $first, $last";
                $rows = $pdo->query($sql)->fetchAll();
            ?>
                <div class="row">
                    <div class="col">
                        共<?= $total_member ?>筆
                    </div>
                </div>

            <?php
            }
            //已回覆？
            if (isset($_GET['statusq']) and strlen($_GET['statusq']) > 0) {
                //搜尋後的頁面排列
                $perPage = 10; // 每一頁最多有幾筆
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                $searchKey = isset($_GET['statusq']) ? ($_GET['statusq']) : '';
                //計算總頁數
                if ($searchKey === 0) {
                    $t_member = "SELECT COUNT(1) FROM `rating` WHERE `reply` is NULL ";
                    $total_member = $pdo->query($t_member)->fetch(PDO::FETCH_NUM)[0];
                    $totalPage = ceil($total_member / $perPage);
                    $first = ($page - 1) * $perPage;
                    $last = $perPage;
                    $rows = [];
                    $sql = "SELECT * FROM `rating` WHERE `reply` is NULL";
                    $rows = $pdo->query($sql)->fetchAll();
                } else {
                    $t_member = "SELECT COUNT(1) FROM `rating` WHERE `reply` IS NOT NULL ";
                    $total_member = $pdo->query($t_member)->fetch(PDO::FETCH_NUM)[0];
                    $totalPage = ceil($total_member / $perPage);
                    $first = ($page - 1) * $perPage;
                    $last = $perPage;
                    $rows = [];
                    $sql = "SELECT * FROM `rating` WHERE `reply` is NOT NULL";
                    $rows = $pdo->query($sql)->fetchAll();
                }
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


        <!-- BT5的表單控制 -->
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button> -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">回覆顧客評論</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-column text-align-center">
                            <p>顧客評論</p>
                            <p id="comment_show">
                            </p>
                        </div>
                        <form name="edit_form" method="POST" class=" d-flex flex-column" onsubmit="edit_reply(event)">
                            <label for="reply_sid" class="form-label text-center">評論編號</label>
                            <input type="text" name="reply_sid" id="reply_sid" class="form-control" value="<?= $r['sid'] ?>">

                            <label for="reply_score" class="form-label text-center">評分</label>
                            <input type="text" name="reply_score" id="reply_score" class="form-control" disabled="disabled" value="<?= $r['score'] ?>/5">

                            <label for="reply_show" class="form-label text-center mt-3">編輯回覆</label>
                            <textarea name="reply_show" class="form-control mt-3" id="reply_show" rows="10" cols="50"></textarea>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>

                                <button class="btn btn-primary mt-3 mb-3" type="submit">送出</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- 表格 -->
        <table class="table table-striped table-hover align-middle">
            <thead class="">
                <tr>
                    <th class="">#</th>
                    <th class="th_person">評論人</th>
                    <th class="th_member">會員</th>
                    <th class="th_rate">評價</th>
                    <th class="th_trails">參加行程</th>
                    <th class="th_date">日期</th>
                    <th class="th_comment">內容</th>
                    <th class="th_reply">回覆</th>
                    <th class="th_act">動作</th>
                    <th class=""></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r) : ?>
                    <tr class="tr_row">
                        <td><?= $r['sid'] ?></td>
                        <td><?= $r['person'] ?></td>
                        <td>
                            <?php foreach ($member_rows as $m_r) : ?>
                                <?php
                                if ($m_r['sid'] === $r['member_sid']) {
                                    echo $m_r['name'];
                                } else {
                                    echo '';
                                }
                                ?>
                            <?php endforeach ?>
                        </td>

                        <td class="td_score">
                            <?php
                            if ($r['score'] == 5) {
                                echo '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>';
                            } else if ($r['score'] == 4) {
                                echo '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>';
                            } else if ($r['score'] == 3) {
                                echo '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>';
                            } else if ($r['score'] == 2) {
                                echo '<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>';
                            } else if ($r['score'] == 1) {
                                echo '<i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>';
                            } else {
                                echo '<i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php foreach ($trail_rows as $t_r) : ?>
                                <?php
                                if ($t_r['sid'] === $r['trails_sid']) {
                                    echo $t_r['trail_name'];
                                }
                                ?>
                            <?php endforeach ?>
                        </td>
                        <td><?= $r['rate_date'] ?></td>
                        <td class="td_comment"><?= $r['comment'] ?></td>
                        <td class="td_comment">
                            <?php
                            if ($r['reply'] === '' || $r['reply'] == NULL) {
                                $reply_btn_text = '回覆';
                                $reply_btn = 'primary';
                                echo '未回覆';
                            } else {
                                $reply_btn_text = '修改';
                                $reply_btn = 'outline-success';
                                echo $r['reply'];
                            }
                            ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-<?= $reply_btn ?>" onclick="openPop([<?= $r['sid'] ?>,'<?= $r['comment'] ?>','<?= $r['reply'] ?>','<?= $r['score'] ?>'])" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <?= $reply_btn_text ?>
                            </button>
                            <a class="btn btn-warning mt-1" onclick="delItem(<?= $r['sid'] ?>)">
                                刪除
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <!-- pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=1">第一頁</a>
                </li>
                <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                    if ($i >= 1 and $i <= $totalPages) :
                ?>
                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                <?php
                    endif;
                endfor;
                ?>
                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $totalPages ?>">最後一頁</a>
                </li>
            </ul>
        </nav>

    </div>
</div>

<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
    //刪除功能
    const rowData = <?= json_encode($r, JSON_UNESCAPED_UNICODE) ?>;
    let s;

    function delItem(sid) {
        if (confirm(`確定要刪除編號${sid}的評論？`)) {
            // event.currentTarget.closest('tr').remove();
            location.href = 'comment-delete-api.php?sid=' + sid;
            console.log('ok');
        } else {
            console.log('canceled');
        }
    }

    //打開popup視窗
    const p = document.querySelector('.popup_card');
    const p_sid = document.querySelector('#reply_sid');
    const p_name = document.querySelector('#reply_name');
    const p_score = document.querySelector('#reply_score');
    const p_comment = document.querySelector('#comment_show');
    const p_reply = document.querySelector('#reply_show');
    const close_btn = document.querySelector('#close_pop');
    const ary = [];

    function openPop(ary) {
        event.preventDefault();
        if (ary) {
            function save_data(ary) {

                p_reply.innerHTML = ary[2];
                p_comment.innerHTML = ary[1];
                p_sid.value = `${ary[0]}`;
                // p_name.value = `的評論`;
                p_score.value = `${ary[3]}/5分`;
            }
            save_data(ary);
            s = p_sid.value;

        }
    }

    //修改回覆

    const edit_reply = function(event) {
        event.preventDefault();
        const fd = new FormData(document.edit_form);
        fetch('comment-edit-api.php', {
            method: 'POST',
            body: fd,
        }).then(response => response.json()).then(obj => {
            console.log(obj);

        })
        // console.log(s);
        const link = Math.ceil(s / <?= $perPage ?>);
        location.href = `comment.php?page=${link}`;
    }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>