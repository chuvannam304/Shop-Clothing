<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<header class="main-header">

    <div class="container">

        <nav class="navbar navbar-expand-lg navbar-light">

            <a class="navbar-brand shop-logo"
                href="index.php?controller=home&action=index">
                NamShop
            </a>

            <button class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#mainNavbar">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">

                <ul class="navbar-nav mx-auto main-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="#">HÀNG MỚI VỀ</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">ÁO NAM</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">QUẦN NAM</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">PHỤ KIỆN</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">SALE</a>
                    </li>

                </ul>

                <div class="header-actions">

                    <a href="#" class="header-icon" title="Tìm kiếm">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>

                    <a href="#" class="header-icon" title="Giỏ hàng">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>

                    <?php if (isset($_SESSION['taiKhoan'])): ?>

                        <a href="index.php?controller=khachhang&action=profile"
                            class="header-account">

                            <div class="header-avatar">

                                <?php if (!empty($_SESSION['taiKhoan']['AnhDaiDien'])): ?>

                                    <img
                                        src="public/uploads/avatars/<?= htmlspecialchars($_SESSION['taiKhoan']['AnhDaiDien']) ?>"
                                        alt="Ảnh đại diện">

                                <?php else: ?>

                                    <i class="fa-regular fa-user"></i>

                                <?php endif; ?>

                            </div>

                            <span class="header-account-name">
                                <?= htmlspecialchars(
                                    $_SESSION['taiKhoan']['HoTen']
                                        ?? strstr($_SESSION['taiKhoan']['Email'] ?? '', '@', true)
                                ) ?>
                            </span>

                        </a>

                    <?php else: ?>

                        <a href="index.php?controller=taikhoan&action=login"
                            class="header-icon"
                            title="Đăng nhập">

                            <i class="fa-regular fa-user"></i>

                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </nav>

    </div>

</header>