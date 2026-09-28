<?php
/** @var array $khachHang */
?>
<div class="admin-page">

    <div class="admin-page-header">

        <div>
            <h2>Chi tiết khách hàng</h2>
            <p>Thông tin tài khoản và hồ sơ khách hàng</p>
        </div>

        <a href="index.php?controller=khachhang&action=index"
            class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Quay lại
        </a>

    </div>

    <div class="customer-detail-card">

        <div class="customer-detail-top">

            <div class="customer-detail-avatar">

                <?php if (!empty($khachHang['AnhDaiDien'])): ?>

                    <img src="public/uploads/avatars/<?= htmlspecialchars($khachHang['AnhDaiDien']) ?>"
                        alt="<?= htmlspecialchars($khachHang['HoTen']) ?>">

                <?php else: ?>

                    <i class="fa-regular fa-user"></i>

                <?php endif; ?>

            </div>

            <div class="customer-detail-name">

                <h3><?= htmlspecialchars($khachHang['HoTen']) ?></h3>

                <span>
                    <?= htmlspecialchars($khachHang['MaKH']) ?>
                </span>

                <?php if ((int) $khachHang['TrangThai'] === 1): ?>

                    <span class="status-badge status-active">
                        Hoạt động
                    </span>

                <?php else: ?>

                    <span class="status-badge status-locked">
                        Đã khóa
                    </span>

                <?php endif; ?>

            </div>

        </div>

        <div class="customer-detail-body">

            <div class="customer-detail-row">

                <div class="customer-detail-item">
                    <label>Mã khách hàng</label>
                    <span><?= htmlspecialchars($khachHang['MaKH']) ?></span>
                </div>

                <div class="customer-detail-item">
                    <label>Mã tài khoản</label>
                    <span><?= htmlspecialchars($khachHang['MaTK']) ?></span>
                </div>

            </div>

            <div class="customer-detail-row">

                <div class="customer-detail-item">
                    <label>Họ và tên</label>
                    <span><?= htmlspecialchars($khachHang['HoTen']) ?></span>
                </div>

                <div class="customer-detail-item">
                    <label>Email</label>
                    <span><?= htmlspecialchars($khachHang['Email']) ?></span>
                </div>

            </div>

            <div class="customer-detail-row">

                <div class="customer-detail-item">
                    <label>Số điện thoại</label>

                    <span>
                        <?= !empty($khachHang['SoDienThoai'])
                            ? htmlspecialchars($khachHang['SoDienThoai'])
                            : 'Chưa cập nhật' ?>
                    </span>
                </div>

                <div class="customer-detail-item">
                    <label>Giới tính</label>

                    <span>
                        <?php
                        if ($khachHang['GioiTinh'] == 'Nam') {
                            echo 'Nam';
                        } elseif ($khachHang['GioiTinh'] == 'Nu') {
                            echo 'Nữ';
                        } elseif ($khachHang['GioiTinh'] == 'Khac') {
                            echo 'Khác';
                        } else {
                            echo 'Chưa cập nhật';
                        }
                        ?>
                    </span>
                </div>

            </div>

            <div class="customer-detail-row">

                <div class="customer-detail-item">
                    <label>Ngày sinh</label>

                    <span>
                        <?= !empty($khachHang['NgaySinh'])
                            ? date('d/m/Y', strtotime($khachHang['NgaySinh']))
                            : 'Chưa cập nhật' ?>
                    </span>
                </div>

                <div class="customer-detail-item">
                    <label>Ngày tạo</label>

                    <span>
                        <?= !empty($khachHang['NgayTao'])
                            ? date('d/m/Y H:i', strtotime($khachHang['NgayTao']))
                            : '' ?>
                    </span>
                </div>

            </div>

        </div>

        <div class="customer-detail-footer">

            <form action="index.php?controller=khachhang&action=changeStatus"
                method="POST">

                <input type="hidden"
                    name="MaTK"
                    value="<?= htmlspecialchars($khachHang['MaTK']) ?>">

                <?php if ((int) $khachHang['TrangThai'] === 1): ?>

                    <input type="hidden" name="TrangThai" value="0">

                    <button type="submit"
                        class="customer-lock-btn"
                        onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">

                        <i class="fa-solid fa-lock"></i>
                        Khóa tài khoản

                    </button>

                <?php else: ?>

                    <input type="hidden" name="TrangThai" value="1">

                    <button type="submit"
                        class="customer-unlock-btn"
                        onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?')">

                        <i class="fa-solid fa-lock-open"></i>
                        Mở khóa tài khoản

                    </button>

                <?php endif; ?>

            </form>

        </div>

    </div>

</div>