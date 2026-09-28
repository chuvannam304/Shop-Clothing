<div class="admin-page">

    <div class="admin-page-header">
        <div>
            <h2>Quản lý tài khoản</h2>
            <p>Danh sách tài khoản trong hệ thống NamShop</p>
        </div>
    </div>

    <div class="admin-card">

        <div class="admin-table-wrapper">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>Mã TK</th>
                        <th>Khách hàng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($taiKhoans)): ?>

                        <?php foreach ($taiKhoans as $taiKhoan): ?>

                            <tr>

                                <td>
                                    <strong><?= htmlspecialchars($taiKhoan['MaTK']) ?></strong>
                                </td>

                                <td>
                                    <?= !empty($taiKhoan['HoTen'])
                                        ? htmlspecialchars($taiKhoan['HoTen'])
                                        : 'Chưa có hồ sơ' ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($taiKhoan['Email']) ?>
                                </td>

                                <td>
                                    <?= !empty($taiKhoan['SoDienThoai'])
                                        ? htmlspecialchars($taiKhoan['SoDienThoai'])
                                        : 'Chưa cập nhật' ?>
                                </td>

                                <td>

                                    <?php if ((int) $taiKhoan['VaiTro'] === 2): ?>

                                        <span class="role-badge role-admin">
                                            Admin
                                        </span>

                                    <?php else: ?>

                                        <span class="role-badge role-customer">
                                            Khách hàng
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <?= !empty($taiKhoan['NgayTao'])
                                        ? date('d/m/Y', strtotime($taiKhoan['NgayTao']))
                                        : '' ?>
                                </td>

                                <td>

                                    <?php if ((int) $taiKhoan['TrangThai'] === 1): ?>

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

                                        <a href="index.php?controller=taikhoan&action=detail&id=<?= urlencode($taiKhoan['MaTK']) ?>"
                                            class="action-btn action-view"
                                            title="Xem chi tiết">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>

                                        <?php
                                        $laTaiKhoanDangDangNhap =
                                            $taiKhoan['MaTK'] == ($_SESSION['taiKhoan']['MaTK'] ?? '');

                                        $laAdmin = (int) $taiKhoan['VaiTro'] === 2;
                                        ?>

                                        <?php if (!$laAdmin && !$laTaiKhoanDangDangNhap): ?>

                                            <form action="index.php?controller=taikhoan&action=changeStatus"
                                                method="POST">

                                                <input type="hidden"
                                                    name="MaTK"
                                                    value="<?= htmlspecialchars($taiKhoan['MaTK']) ?>">

                                                <?php if ((int) $taiKhoan['TrangThai'] === 1): ?>

                                                    <input type="hidden"
                                                        name="TrangThai"
                                                        value="0">

                                                    <button type="submit"
                                                        class="action-btn action-lock"
                                                        title="Khóa tài khoản"
                                                        onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">

                                                        <i class="fa-solid fa-lock"></i>

                                                    </button>

                                                <?php else: ?>

                                                    <input type="hidden"
                                                        name="TrangThai"
                                                        value="1">

                                                    <button type="submit"
                                                        class="action-btn action-unlock"
                                                        title="Mở khóa tài khoản"
                                                        onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?')">

                                                        <i class="fa-solid fa-lock-open"></i>

                                                    </button>

                                                <?php endif; ?>

                                            </form>

                                        <?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="8" class="admin-empty">
                                Chưa có tài khoản nào.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>