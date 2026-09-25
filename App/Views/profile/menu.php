<?php

$currentAction = $_GET['action'] ?? 'profile';

$accountActions = [
    'profile',
    'bank',
    'address',
    'changePassword',
    'notificationSettings',
    'privacy',
    'personalInfo'
];

$openAccountMenu = in_array($currentAction, $accountActions);

?>

<div class="profile-sidebar">

    <div class="profile-sidebar-user">
        <div class="profile-sidebar-avatar">
            <?php if (!empty($khachHang['AnhDaiDien'])): ?>
                <img src="public/uploads/avatars/<?= htmlspecialchars($khachHang['AnhDaiDien']) ?>" alt="Ảnh đại diện">
            <?php else: ?>
                <i class="fa-regular fa-user"></i>
            <?php endif; ?>
        </div>

        <div class="profile-sidebar-user-info">
            <strong>
                <?= htmlspecialchars($khachHang['HoTen'] ?? '') ?>
            </strong>

            <a href="index.php?controller=khachhang&action=profile">Sửa Hồ Sơ</a>
        </div>
    </div>

    <div class="profile-sidebar-menu">

        <button type="button" class="profile-account-toggle" id="accountMenuToggle">
            <span>Tài Khoản Của Tôi</span>
            <i class="fa-solid fa-chevron-down account-arrow <?= $openAccountMenu ? 'open' : '' ?>" id="accountMenuArrow"></i>
        </button>

        <div class="profile-account-submenu <?= $openAccountMenu ? 'show' : '' ?>" id="accountSubmenu">

            <a href="index.php?controller=khachhang&action=profile" class="<?= $currentAction == 'profile' ? 'active' : '' ?>">
                Hồ Sơ
            </a>

            <a href="index.php?controller=khachhang&action=bank" class="<?= $currentAction == 'bank' ? 'active' : '' ?>">
                Ngân Hàng
            </a>

            <a href="index.php?controller=khachhang&action=address" class="<?= $currentAction == 'address' ? 'active' : '' ?>">
                Địa Chỉ
            </a>

            <a href="index.php?controller=khachhang&action=changePassword" class="<?= $currentAction == 'changePassword' ? 'active' : '' ?>">
                Đổi Mật Khẩu
            </a>

            <a href="index.php?controller=khachhang&action=notificationSettings" class="<?= $currentAction == 'notificationSettings' ? 'active' : '' ?>">
                Cài Đặt Thông Báo
            </a>

            <a href="index.php?controller=khachhang&action=privacy" class="<?= $currentAction == 'privacy' ? 'active' : '' ?>">
                Những Thiết Lập Riêng Tư
            </a>

            <a href="index.php?controller=khachhang&action=personalInfo" class="<?= $currentAction == 'personalInfo' ? 'active' : '' ?>">
                Thông Tin Cá Nhân
            </a>

        </div>

        <a href="index.php?controller=khachhang&action=orders" class="profile-main-menu <?= $currentAction == 'orders' ? 'active' : '' ?>">
            Đơn Mua
        </a>

        <a href="#" class="profile-main-menu">
            Kho Voucher
        </a>

        <a href="#" class="profile-main-menu">
            Thông Báo
        </a>

        <a href="index.php?controller=home&action=index" class="profile-main-menu">
            Trang Chủ
        </a>

        <a href="index.php?controller=taikhoan&action=logout" class="profile-main-menu">
            Đăng Xuất
        </a>

    </div>

</div>

<script>
    const accountMenuToggle = document.getElementById('accountMenuToggle');
    const accountSubmenu = document.getElementById('accountSubmenu');
    const accountMenuArrow = document.getElementById('accountMenuArrow');

    accountMenuToggle.addEventListener('click', function() {
        accountSubmenu.classList.toggle('show');
        accountMenuArrow.classList.toggle('open');
    });
</script>