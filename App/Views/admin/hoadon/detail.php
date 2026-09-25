<?php
/** @var array $hoaDon */
/** @var array $trangThais */
?>
<div class="admin-page">

    <div class="admin-page-header">
        <div>
            <h2>Chi tiết đơn hàng #<?= htmlspecialchars($hoaDon['MaHD']) ?></h2>
            <p>Thông tin chi tiết và trạng thái đơn hàng</p>
        </div>

        <a href="index.php?controller=hoadon&action=index" class="btn-order-back">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <?php if (($_GET['success'] ?? '') == 'status'): ?>
        <div class="order-detail-message success">Cập nhật trạng thái đơn hàng thành công.</div>
    <?php endif; ?>

    <?php if (($_GET['success'] ?? '') == 'payment'): ?>
        <div class="order-detail-message success">Cập nhật trạng thái thanh toán thành công.</div>
    <?php endif; ?>

    <div class="row">

        <div class="col-lg-8">

            <div class="order-detail-card">
                <div class="order-detail-title">
                    <h3>Thông tin đơn hàng</h3>
                </div>

                <div class="row order-detail-info">
                    <div class="col-md-6">
                        <div class="order-info-row">
                            <span>Mã đơn hàng</span>
                            <strong><?= htmlspecialchars($hoaDon['MaHD']) ?></strong>
                        </div>

                        <div class="order-info-row">
                            <span>Khách hàng</span>
                            <strong><?= htmlspecialchars($hoaDon['TenKhachHang'] ?? '') ?></strong>
                        </div>

                        <div class="order-info-row">
                            <span>Email</span>
                            <strong><?= htmlspecialchars($hoaDon['Email'] ?? '') ?></strong>
                        </div>

                        <div class="order-info-row">
                            <span>Số điện thoại</span>
                            <strong><?= htmlspecialchars($hoaDon['SoDienThoai'] ?? '') ?></strong>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="order-info-row">
                            <span>Ngày đặt</span>
                            <strong><?= !empty($hoaDon['NgayDat']) ? date('d/m/Y H:i', strtotime($hoaDon['NgayDat'])) : '' ?></strong>
                        </div>

                        <div class="order-info-row">
                            <span>Phương thức thanh toán</span>
                            <strong><?= htmlspecialchars($hoaDon['TenPhuongThuc'] ?? '') ?></strong>
                        </div>

                        <div class="order-info-row">
                            <span>Trạng thái đơn</span>
                            <strong><?= htmlspecialchars($hoaDon['TenTrangThai'] ?? '') ?></strong>
                        </div>

                        <div class="order-info-row">
                            <span>Thanh toán</span>
                            <strong><?= htmlspecialchars($hoaDon['TrangThaiThanhToan'] ?? '') ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-detail-card">
                <div class="order-detail-title">
                    <h3>Thông tin nhận hàng</h3>
                </div>

                <div class="order-shipping-info">
                    <div class="order-info-row">
                        <span>Người nhận</span>
                        <strong><?= htmlspecialchars($hoaDon['HoTenNguoiNhan'] ?? '') ?></strong>
                    </div>

                    <div class="order-info-row">
                        <span>Số điện thoại</span>
                        <strong><?= htmlspecialchars($hoaDon['SoDienThoaiNhan'] ?? '') ?></strong>
                    </div>

                    <div class="order-info-row">
                        <span>Địa chỉ</span>
                        <strong><?= htmlspecialchars($hoaDon['DiaChiGiaoHang'] ?? '') ?></strong>
                    </div>

                    <div class="order-info-row">
                        <span>Ghi chú</span>
                        <strong><?= !empty($hoaDon['GhiChu']) ? htmlspecialchars($hoaDon['GhiChu']) : 'Không có' ?></strong>
                    </div>
                </div>
            </div>

            <div class="order-detail-card">
                <div class="order-detail-title">
                    <h3>Sản phẩm</h3>
                </div>

                <div class="table-responsive">
                    <table class="table order-detail-product-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Phân loại</th>
                                <th>SKU</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($chiTietHoaDons)): ?>

                                <?php foreach ($chiTietHoaDons as $chiTiet): ?>
                                    <tr>
                                        <td>
                                            <div class="order-detail-product">
                                                <div class="order-detail-product-image">
                                                    <?php if (!empty($chiTiet['HinhAnhChinh'])): ?>
                                                        <img src="public/uploads/products/<?= htmlspecialchars($chiTiet['HinhAnhChinh']) ?>" alt="<?= htmlspecialchars($chiTiet['TenSP']) ?>">
                                                    <?php else: ?>
                                                        <div class="order-detail-no-image">
                                                            <i class="fa-regular fa-image"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <span><?= htmlspecialchars($chiTiet['TenSP']) ?></span>
                                            </div>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($chiTiet['TenMau'] ?? '') ?>
                                            /
                                            <?= htmlspecialchars($chiTiet['TenSize'] ?? '') ?>
                                        </td>

                                        <td><?= htmlspecialchars($chiTiet['MaSKU'] ?? '') ?></td>

                                        <td><?= (int) ($chiTiet['SoLuong'] ?? 0) ?></td>

                                        <td><?= number_format($chiTiet['DonGia'] ?? 0, 0, ',', '.') ?>đ</td>

                                        <td><strong><?= number_format($chiTiet['ThanhTien'] ?? 0, 0, ',', '.') ?>đ</strong></td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="6" class="text-center">Không có sản phẩm trong đơn hàng.</td>
                                </tr>

                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="order-detail-card">
                <div class="order-detail-title">
                    <h3>Thanh toán</h3>
                </div>

                <div class="order-money-row">
                    <span>Tổng tiền hàng</span>
                    <strong><?= number_format($hoaDon['TongTien'] ?? 0, 0, ',', '.') ?>đ</strong>
                </div>

                <div class="order-money-row">
                    <span>Giảm giá</span>
                    <strong>-<?= number_format($hoaDon['TienGiam'] ?? 0, 0, ',', '.') ?>đ</strong>
                </div>

                <div class="order-money-row">
                    <span>Phí vận chuyển</span>
                    <strong><?= number_format($hoaDon['PhiVanChuyen'] ?? 0, 0, ',', '.') ?>đ</strong>
                </div>

                <div class="order-money-row order-money-total">
                    <span>Thành tiền</span>
                    <strong><?= number_format($hoaDon['ThanhTien'] ?? 0, 0, ',', '.') ?>đ</strong>
                </div>

                <?php if (!empty($hoaDon['MaCode'])): ?>
                    <div class="order-discount-code">
                        Mã giảm giá: <strong><?= htmlspecialchars($hoaDon['MaCode']) ?></strong>
                    </div>
                <?php endif; ?>
            </div>

            <div class="order-detail-card">
                <div class="order-detail-title">
                    <h3>Cập nhật trạng thái</h3>
                </div>

                <form action="index.php?controller=hoadon&action=updateStatus" method="POST">
                    <input type="hidden" name="MaHD" value="<?= htmlspecialchars($hoaDon['MaHD']) ?>">

                    <div class="order-detail-form-group">
                        <label>Trạng thái đơn hàng</label>

                        <select name="MaTrangThai" class="form-control" required>
                            <?php foreach ($trangThais as $trangThai): ?>
                                <option value="<?= htmlspecialchars($trangThai['MaTrangThai']) ?>"
                                    <?= ($hoaDon['MaTrangThai'] ?? '') == $trangThai['MaTrangThai'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($trangThai['TenTrangThai']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn-order-update">Cập nhật trạng thái</button>
                </form>
            </div>

            <div class="order-detail-card">
                <div class="order-detail-title">
                    <h3>Trạng thái thanh toán</h3>
                </div>

                <form action="index.php?controller=hoadon&action=updatePayment" method="POST">
                    <input type="hidden" name="MaHD" value="<?= htmlspecialchars($hoaDon['MaHD']) ?>">

                    <div class="order-detail-form-group">
                        <label>Thanh toán</label>

                        <select name="TrangThaiThanhToan" class="form-control" required>
                            <option value="ChuaThanhToan" <?= ($hoaDon['TrangThaiThanhToan'] ?? '') == 'ChuaThanhToan' ? 'selected' : '' ?>>
                                Chưa thanh toán
                            </option>

                            <option value="DaThanhToan" <?= ($hoaDon['TrangThaiThanhToan'] ?? '') == 'DaThanhToan' ? 'selected' : '' ?>>
                                Đã thanh toán
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn-order-update">Cập nhật thanh toán</button>
                </form>
            </div>

        </div>

    </div>

</div>