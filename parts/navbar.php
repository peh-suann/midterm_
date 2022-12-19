<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 240px; height: 100vh; position: fixed;">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <i class="fa-brands fa-bootstrap"></i>
        <span class="fs-4">PEH-SUANN</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= PROJ_ROOT ?>/trails.php" class="nav-link link-dark <?= $pageName == 'trails' ? 'active' : '' ?>" aria-current="page">
                <i class="fa-solid fa-mountain"></i>
                商品管理
            </a>
        </li>
        <li>
            <a href="<?= PROJ_ROOT ?>/order.php" class="nav-link link-dark <?= $pageName == 'order' ? 'active' : '' ?>">
                <i class="fa-solid fa-basket-shopping"></i>
                訂單管理
            </a>
        </li>
        <li>
            <a href="<?= PROJ_ROOT ?>/member.php" class="nav-link link-dark <?= $pageName == 'member' ? 'active' : '' ?>">
                <i class="fa-solid fa-users"></i>
                會員管理
            </a>
        </li>
        <li>
            <a href="<?= PROJ_ROOT ?>/coupon_list.php" class="nav-link link-dark <?= $pageName == 'coupon' ? 'active' : '' ?>">
                <i class="fa-solid fa-ticket-simple"></i>
                優惠券管理
            </a>
        </li>
        <!-- <li>
                <a href="<?= PROJ_ROOT ?>/achieve.php" class="nav-link link-dark <?= $pageName == 'achieve' ? 'active' : '' ?>">
                    <i class="fa-solid fa-award"></i>
                    成就系統
                </a>
            </li> -->
        <li>
            <a href="<?= PROJ_ROOT ?>/comment.php" class="nav-link link-dark <?= $pageName == 'comment' ? 'active' : '' ?>">
                <i class="fa-solid fa-comments"></i>
                評價系統
            </a>
        </li>
        <?php if (isset($_SESSION['admin'])) : ?>
            <li>
                <a class="nav-link link-dark <?= $pageName == 'login' ? 'active' : '' ?>">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <?= $_SESSION['admin']['account']  ?>
                </a>
            </li>
            <li>
                <a href="<?= PROJ_ROOT ?>/logout.php" class="nav-link link-dark <?= $pageName == 'logout' ? 'active' : '' ?>">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    登出
                </a>
            </li>
        <?php else : ?>
            <li>
                <a href="<?= PROJ_ROOT ?>/login.php" class="nav-link link-dark <?= $pageName == 'login' ? 'active' : '' ?>">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    登入
                </a>
            </li>
            <li>
                <a href="<?= PROJ_ROOT ?>/register-admin.php" class="nav-link link-dark <?= $pageName == 'logout' ? 'active' : '' ?>">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    註冊
                </a>
            </li>
        <?php endif ?>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>mdo</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
</div>
<div class="container-fluid p-0 main">