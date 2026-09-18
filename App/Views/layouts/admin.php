<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Trang quản trị' ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>

    <div class="admin">

        <div class="sidebar">
            <div class="logo">CLOTHING SHOP</div>

            <ul class="menu">

                <li class="<?= ($activeMenu ?? '') == 'dashboard' ? 'active' : '' ?>">
                    <a href="index.php?controller=admin&action=dashboard"><i class="fa-solid fa-house"></i> Trang chủ</a>
                </li>

                <li class="<?= ($activeMenu ?? '') == 'sanpham' ? 'active' : '' ?>">
                    <a href="index.php?controller=sanpham&action=index"><i class="fa-solid fa-shirt"></i> Sản phẩm</a>
                </li>

                <li class="<?= ($activeMenu ?? '') == 'hoadon' ? 'active' : '' ?>">
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i> Đơn hàng</a>
                    <!-- <a href="index.php?controller=hoadon&action=index"><i class="fa-solid fa-cart-shopping"></i> Đơn hàng</a> -->
                </li>

                <li class="<?= ($activeMenu ?? '') == 'khachhang' ? 'active' : '' ?>">
                    <!-- <a href="index.php?controller=khachhang&action=index"><i class="fa-solid fa-users"></i> Khách hàng</a> -->
                    <a href="#"><i class="fa-solid fa-users"></i> Khách hàng</a>
                </li>

                <li class="<?= ($activeMenu ?? '') == 'magiamgia' ? 'active' : '' ?>">
                    <a href="#"><i class="fa-solid fa-ticket"></i> Mã giảm giá</a>
                    <!-- <a href="index.php?controller=magiamgia&action=index"><i class="fa-solid fa-ticket"></i> Mã giảm giá</a> -->
                </li>

                <li class="<?= ($activeMenu ?? '') == 'nhacungcap' ? 'active' : '' ?>">
                    <a href="#"><i class="fa-solid fa-truck"></i> Nhà cung cấp</a>
               <!-- <a href="index.php?controller=nhacungcap&action=index"><i class="fa-solid fa-truck"></i> Nhà cung cấp</a> -->
                </li>

                <li class="<?= ($activeMenu ?? '') == 'phieunhap' ? 'active' : '' ?>">
                    <!-- <a href="index.php?controller=phieunhap&action=index"><i class="fa-solid fa-boxes-stacked"></i> Nhập hàng</a> -->
                    <a href="#"><i class="fa-solid fa-boxes-stacked"></i> Nhập hàng</a>
                </li>
                <li class="<?= ($activeMenu ?? '') == 'taikhoan' ? 'active' : '' ?>">
                    <a href="#"><i class="fa-solid fa-user-gear"></i> Tài khoản</a>
                    <!-- <a href="index.php?controller=taikhoan&action=index"><i class="fa-solid fa-user-gear"></i> Tài khoản</a> -->
                </li>

                <li class="<?= ($activeMenu ?? '') == 'phanhoi' ? 'active' : '' ?>">
                    <a href="#"><i class="fa-solid fa-comments"></i> Đánh giá & Bình luận</a>
                    <!-- <a href="index.php?controller=phanhoi&action=index"><i class="fa-solid fa-comments"></i> Đánh giá & Bình luận</a> -->
                </li>

                <li class="<?= ($activeMenu ?? '') == 'thongbao' ? 'active' : '' ?>">
                    <a href="#"><i class="fa-solid fa-bell"></i> Thông báo</a>
                    <!-- <a href="index.php?controller=thongbao&action=index"><i class="fa-solid fa-bell"></i> Thông báo</a> -->
                </li>

            </ul>
        </div>

        <div class="main">

            <div class="header">
                <h2>Trang quản trị</h2>
                <div class="admin-user"><i class="fa-solid fa-user"></i> <span>Admin</span></div>
            </div>
            <div class="content">
                <?php
                if (isset($view) && file_exists($view)) {
                    require $view;
                }
                ?>
            </div>

        </div>

    </div>

</body>

</html>