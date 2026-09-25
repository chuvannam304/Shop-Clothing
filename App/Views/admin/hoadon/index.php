<div class="admin-page">

    <div class="admin-page-header">
        <div>
            <h2>Quản lý đơn hàng</h2>
            <p>Theo dõi và quản lý các đơn hàng của khách hàng</p>
        </div>
    </div>

    <div class="order-admin-filter">

        <form action="index.php" method="GET" class="order-admin-search">
            <input type="hidden" name="controller" value="hoadon">
            <input type="hidden" name="action" value="index">

            <div class="order-admin-search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="keyword"
                    value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                    placeholder="Tìm mã đơn, khách hàng, người nhận, số điện thoại...">
            </div>

            <button type="submit" class="btn-order-search">Tìm kiếm</button>

            <?php if (!empty($_GET['keyword'])): ?>
                <a href="index.php?controller=hoadon&action=index" class="btn-order-reset">Đặt lại</a>
            <?php endif; ?>
        </form>

    </div>

    <div class="order-admin-card">

        <div class="table-responsive">

            <table class="table order-admin-table">

                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Thanh toán</th>
                        <th>Thành tiền</th>
                        <th>Trạng thái</th>
                        <th>TT thanh toán</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($hoaDons)): ?>

                        <?php foreach ($hoaDons as $hoaDon): ?>

                            <tr>

                                <td>
                                    <strong><?= htmlspecialchars($hoaDon['MaHD']) ?></strong>
                                </td>

                                <td>
                                    <?= htmlspecialchars($hoaDon['TenKhachHang'] ?? '') ?>
                                </td>

                                <td>
                                    <?= !empty($hoaDon['NgayDat']) ? date('d/m/Y H:i', strtotime($hoaDon['NgayDat'])) : '' ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($hoaDon['TenPhuongThuc'] ?? '') ?>
                                </td>

                                <td>
                                    <strong><?= number_format($hoaDon['ThanhTien'] ?? 0, 0, ',', '.') ?>đ</strong>
                                </td>

                                <td>
                                    <span class="order-admin-status">
                                        <?= htmlspecialchars($hoaDon['TenTrangThai'] ?? '') ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if (($hoaDon['TrangThaiThanhToan'] ?? '') == 'DaThanhToan'): ?>

                                        <span class="payment-status payment-paid">
                                            Đã thanh toán
                                        </span>

                                    <?php else: ?>

                                        <span class="payment-status payment-unpaid">
                                            Chưa thanh toán
                                        </span>

                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="index.php?controller=hoadon&action=detail&id=<?= urlencode($hoaDon['MaHD']) ?>"
                                        class="btn-order-detail">
                                        <i class="fa-regular fa-eye"></i>
                                        Xem
                                    </a>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="8" class="order-admin-empty">
                                <i class="fa-solid fa-box-open"></i>
                                <p>Không có đơn hàng nào.</p>
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>