<div class="admin-page">

    <div class="admin-page-header">
        <div>
            <h2>Quản lý khách hàng</h2>
            <p>Danh sách tài khoản khách hàng của NamShop</p>
        </div>
    </div>

    <div class="admin-card">

        <div class="admin-table-wrapper">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>Mã KH</th>
                        <th>Khách hàng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Giới tính</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($khachHangs)): ?>

                        <?php foreach ($khachHangs as $khachHang): ?>

                            <tr>

                                <td>
                                    <strong><?= htmlspecialchars($khachHang['MaKH']) ?></strong>
                                </td>

                                <td>
                                    <div class="customer-info">

                                        <div class="customer-avatar">

                                            <?php if (!empty($khachHang['AnhDaiDien'])): ?>

                                                <img src="public/uploads/avatars/<?= htmlspecialchars($khachHang['AnhDaiDien']) ?>"
                                                    alt="<?= htmlspecialchars($khachHang['HoTen']) ?>">

                                            <?php else: ?>

                                                <i class="fa-regular fa-user"></i>

                                            <?php endif; ?>

                                        </div>

                                        <span><?= htmlspecialchars($khachHang['HoTen']) ?></span>

                                    </div>
                                </td>

                                <td>
                                    <?= htmlspecialchars($khachHang['Email']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($khachHang['SoDienThoai'] ?? '') ?>
                                </td>

                                <td>
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
                                </td>

                                <td>
                                    <?= !empty($khachHang['NgayTao']) ? date('d/m/Y', strtotime($khachHang['NgayTao'])) : '' ?>
                                </td>

                                <td>

                                    <?php if ((int) $khachHang['TrangThai'] === 1): ?>

                                        <span class="status-badge status-active">
                                            Hoạt động
                                        </span>

                                    <?php else: ?>

                                        <span class="status-badge status-locked">
                                            Đã khóa
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <div class="admin-actions">

                                        <a href="index.php?controller=khachhang&action=detail&id=<?= urlencode($khachHang['MaKH']) ?>"
                                            class="action-btn action-view"
                                            title="Xem chi tiết">

                                            <i class="fa-regular fa-eye"></i>

                                        </a>

                                        <form action="index.php?controller=khachhang&action=changeStatus"
                                            method="POST">

                                            <input type="hidden"
                                                name="MaTK"
                                                value="<?= htmlspecialchars($khachHang['MaTK']) ?>">

                                            <?php if ((int) $khachHang['TrangThai'] === 1): ?>

                                                <input type="hidden" name="TrangThai" value="0">

                                                <button type="submit"
                                                    class="action-btn action-lock"
                                                    title="Khóa tài khoản"
                                                    onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">

                                                    <i class="fa-solid fa-lock"></i>

                                                </button>

                                            <?php else: ?>

                                                <input type="hidden" name="TrangThai" value="1">

                                                <button type="submit"
                                                    class="action-btn action-unlock"
                                                    title="Mở khóa tài khoản"
                                                    onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?')">

                                                    <i class="fa-solid fa-lock-open"></i>

                                                </button>

                                            <?php endif; ?>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="8" class="admin-empty">
                                Chưa có khách hàng nào.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>