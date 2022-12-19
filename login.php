<?php require __DIR__ . '/parts/connect_db.php'; ?>
<?php
$pageName = "login";
$title = "管理者登入";

if (isset($_SESSION['admin'])) {
    header('Location: index_.php');
    exit;
}
if (!isset($_SESSION)) {
    session_start();
}
?>
<?php require __DIR__ . '/parts/html-head.php'; ?>

<div class="col-12" id="login_background">
    <div class="container col-6">
        <div class="row login-card pt-3">
            <h4>peh-suann後台管理登入</h4>
            <form name="loginform" method="POST" onsubmit="checkForm(event)" novalidate>
                <div class="mb-3">
                    <div class="col-10" id="note">

                    </div>

                    <label for="account" class="form-label mt-3">Email 登入</label>
                    <input type="account" name="account" class="form-control" id="account" placeholder="Enter your email here" required>
                    <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    <div class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">請輸入密碼</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password here">
                    <div class="form-text"></div>
                </div>
                <button type="submit" class="btn btn-primary mb-3 ">登入</button>
            </form>
        </div>
    </div>
</div>
<?php require __DIR__ . '/parts/scripts.php'; ?>
<script>
    //取消表格預設的刷新頁面＆回復輸入格樣式

    const checkForm = function(event) {
        event.preventDefault();
        document.loginform.querySelectorAll('input').forEach(function(el) {
            el.style.border = '1px solid #cccccc';
            el.nextElementSibling.innerHTML = '';
        })
        //帳號無輸入
        let isPass = true;
        let field = document.loginform.account;


        if (!field.value.length) {
            isPass = false;
            field.style.border = "2px solid red";
            field.nextElementSibling.innerHTML = '請輸入email';

        }


        //密碼無輸入
        field = document.loginform.password;
        if (!field.value.length) {
            isPass = false;
            field.style.border = '2px solid red';
            field.nextElementSibling.innerHTML = '請輸入密碼';

        }



        if (isPass) {
            const fd = new FormData(document.loginform);


            fetch('login-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json()).then(obj => {
                console.log(obj);
                if (obj.success) {
                    const n = document.createElement("div");

                    n.className = `alert alert-info mt-2`;
                    n.innerHTML = '登入成功，將轉至後台首頁';
                    document.querySelector('#note').appendChild(n);
                    // setTimeout(()=> document.querySelector('.alert').remove(),3000);
                    setTimeout(() => (location.href = 'index_.php'), 500);
                    // console.log($_SESSION['admin']);

                } else {
                    // alert('帳號或密碼錯誤');
                    const n = document.createElement("div");

                    n.className = `alert alert-danger mt-2`;
                    n.innerHTML = '帳號或密碼錯誤，請重新登入';
                    document.querySelector('#note').appendChild(n);
                    setTimeout(() => document.querySelector('.alert').remove(), 500);
                }
            })
        };

    }
</script>
<?php require __DIR__ . '/parts/html-foot.php'; ?>