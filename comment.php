<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "comment";
$title = "評論管理";
if (!isset($_SESSION)) {
    session_start();
}

//列表控制
$perpage = 10; //每一頁的最高筆數
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM rating";
//取得總比數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
//總頁數
$totalPages = ceil($totalRows / $perpage);

$rows = [];
$rows_sql = "SELECT * FROM `rating` WHERE 1";
$sql = sprintf("SELECT * FROM `rating` ORDER BY `sid` ASC LIMIT %s, %s", ($page - 1) * $perpage, $perpage);
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
        <h2>comment</h2>
        <!-- 篩選功能欄位 -->

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
                            <input type="text" name="reply_sid" id="reply_sid" class="form-control" value="<?= $rows['sid'] ?>">
                            <!-- <input type="text" name="reply_name" id="reply_name" class="form-control" disabled="disabled" value=""> -->
                            <label for="reply_score" class="form-label text-center">評分</label>
                            <input type="text" name="reply_score" id="reply_score" class="form-control" disabled="disabled" value="<?= $rows['score'] ?>/5">

                            <label for="reply_show" class="form-label text-center mt-3">編輯回覆</label>
                            <textarea name="reply_show" class="form-control mt-3" id="reply_show" rows="10" cols="50"></textarea>
                            <!-- <button class="btn btn-primary mt-3 mb-3" type="submit">送出</button> -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                                <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                                <button class="btn btn-primary mt-3 mb-3" type="submit">送出</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- 跳出修改視窗 -->

        <!-- <div class="popup_card" id="popup_card">
            <div class="popup_flex d-flex pt-3">
                <i class="fa-regular fa-circle-xmark" onclick="closePop()" id="close_pop"></i>
                <div class="comment_area me-2">
                    <h6 class="text-center">顧客評價</h6>
                    <div class="comment_box">
                        <p class=" pt-3 pe-2" id="comment_show">

                        </p>
                    </div>
                </div>
                <form name="edit_form" method="POST" class="reply_area d-flex flex-column" onsubmit="edit_reply(event)">
                    <label for="reply_sid" class="form-label text-center">評論編號</label>
                    <input type="text" name="reply_sid" id="reply_sid" class="form-control" value="<?= $rows['sid'] ?>">
                    
                    <label for="reply_score" class="form-label text-center">評分</label>
                    <input type="text" name="reply_score" id="reply_score" class="form-control" disabled="disabled" value="<?= $rows['score'] ?>/5">

                    <label for="reply_show" class="form-label text-center mt-3">編輯回覆</label>
                    <textarea name="reply_show" class="form-control mt-3" id="reply_show" rows="10" cols="50"></textarea>
                    <button class="btn btn-primary mt-3 mb-3" type="submit">送出</button>
                </form>

            </div>
        </div> -->

        <!-- 表格 -->
        <table class="table table-striped table-hover align-middle">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th class="th_member">評論人</th>
                    <th class="th_rate">評價</th>
                    <th class="th_trails">參加行程</th>
                    <th class="th_date">日期</th>
                    <th class="th_comment">內容</th>
                    <th class="th_reply">回覆</th>
                    <th>動作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r) : ?>
                    <tr class="tr_row">
                        <td><?= $r['sid'] ?></td>
                        <td>
                            <?php foreach ($member_rows as $m_r) : ?>
                                <?php
                                if ($m_r['sid'] === $r['member_sid']) {
                                    echo $m_r['name'];
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
                            <!-- <a class="btn btn-<?= $reply_btn ?>" onclick="openPop([<?= $r['sid'] ?>,'<?= $r['comment'] ?>','<?= $r['reply'] ?>','<?= $r['score'] ?>'])"> <?= $reply_btn_text ?></a> -->
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
            location.href = 'comment-delete.php?sid=' + sid;
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
        // location.href = `?sid=${sid}`;
        event.preventDefault();
        if (ary) {
            // p.classList.remove('popup_card');
            // p.classList.add('popup_card_open');

            function save_data(ary) {

                p_reply.innerHTML = ary[2];
                p_comment.innerHTML = ary[1];
                p_sid.value = `${ary[0]}`;
                // p_name.value = `的評論`;
                p_score.value = `${ary[3]}/5分`;
            }
            save_data(ary);
            s = p_sid.value;

            // console.log(s);
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
        const link = Math.ceil(s / <?= $perpage ?>);
        location.href = `comment.php?page=${link}`;
        // location.href = document.referrer;
    }

    function closePop() {
        p.classList.remove('popup_card_open');
        p.classList.add('popup_card');
    }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>