<?php

require __DIR__ . '/parts/connect_db.php';
$pageName = "register-admin";
$title = "管理者註冊";

if (isset($_SESSION['admin'])) {
    header('Location: index_.php');
    exit;
}
if (!isset($_SESSION)) {
    session_start();
}

require __DIR__ . '/parts/html-head.php';

?>
<style>
    .form-text {
        color: red;
    }

    .login-card {
        background-color: #F8F9FA;
        border-radius: 5px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        height: 350px;
        margin-top: 20%;
    }

    h4 {
        margin: 0 auto;
    }

    button {
        margin: 0 auto;
    }
</style>
<?php require __DIR__ . '/parts/navbar.php'; ?>
<div class="container col-6">
    <div class="row login-card pt-3">
        <h4>peh-suann註冊管理者</h4>
        <form name="adRegistForm" method="POST" onsubmit="checkForm(event)" novalidate>
            <div class="mb-3">
                <div class="col-10" id="note">

                </div>

                <label for="account" class="form-label">Email</label>
                <input type="account" name="account" class="form-control" id="account" placeholder="Enter your email here" required>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                <div class="form-text"></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">輸入密碼</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password here">
                <div class="form-text"></div>
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">再次輸入密碼</label>
                <input type="password" name="password2" class="form-control" id="password2" placeholder="Verify your password">
                <div class="form-text"></div>
            </div>
            <button type="submit" class="btn btn-primary">註冊</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/parts/scripts.php'; ?>
<script>
    //取消表格預設的刷新頁面＆回復輸入格樣式
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;

    const checkForm = function(event) {
        event.preventDefault();
        document.adRegistForm.querySelectorAll('input').forEach(function(el) {
            el.style.border = '1px solid #cccccc';
            el.nextElementSibling.innerHTML = '';
        });
        //帳號無輸入
        let isPass = true;

        const field = ['account', 'password', 'password2']
        const field1 = document.adRegistForm.account;


        if (!field1.value.length) {
            isPass = false;
            field.style.border = "2px solid red";
            field.nextElementSibling.innerHTML = '請輸入email';
        }

        //密碼無輸入
        const field2 = document.adRegistForm.password;
        if (!field2.value.length) {
            isPass = false;
            field2.style.border = '2px solid red';
            field2.nextElementSibling.innerHTML = '請輸入密碼';
        }
        //無驗證
        const field3 = document.adRegistForm.password2;
        if (!field3.value.length) {
            isPass = false;
            field3.style.border = '2px solid red';
            field3.nextElementSibling.innerHTML = '請驗證密碼';
        }
        //密碼與驗證不一樣
        if (field2.value === field3.value) {
            isPass = true;
        } else {
            isPass = false;
            field2.style.border = '2px solid red';
            field3.style.border = '2px solid red';
            field3.nextElementSibling.innerHTML = '密碼驗證失敗';
        };
        //email資料格式驗證
        if (!email_re.test(field1.value)) {
            isPass = false;
            field1.style.border = "2px solid red";
            field1.nextElementSibling.innerHTML = '請輸入正確email格式';
        }



        if (isPass) {
            const fd = new FormData(document.adRegistForm);
            // console.log(document.adRegistForm);
            fetch('register-admin-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json()).then(obj => {
                console.log(obj);
                if (obj.success) {
                    const n = document.createElement("div");
                    n.innerHTML = '註冊成功，將轉至後台首頁';
                    n.className = 'alert alert-info';
                    document.querySelector('#note').appendChild(n);
                    setTimeout(() => (location.href = 'index_.php'), 3000);

                } else {
                    alert('請重新註冊');

                }
            })
        };

    }
</script>
<?php require __DIR__ . '/parts/html-foot.php'; ?>