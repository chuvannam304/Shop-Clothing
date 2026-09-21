<?php
/** @var array $sanPham */
/** @var array $dsBienThe */
?>

<div class="page-title">
    <div>
        <h1>Biến thể Sản phẩm</h1>
        <p><?= htmlspecialchars($sanPham['MaSP']) ?> - <?= htmlspecialchars($sanPham['TenSP']) ?></p>
    </div>

    <a href="index.php?controller=sanphambienthe&action=create&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm Biến thể</a>
</div>

<div class="product-tools">
    <a href="index.php?controller=sanpham&action=index" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại Sản phẩm</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Danh sách Biến thể</h2>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã biến thể</th>
                    <th>Màu sắc</th>
                    <th>Size</th>
                    <th>SKU</th>
                    <th>Giá bán</th>
                    <th>Số lượng tồn</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dsBienThe)): ?>

                    <?php foreach ($dsBienThe as $bienThe): ?>
                        <tr>
                            <td><?= htmlspecialchars($bienThe['MaBienThe']) ?></td>

                            <td>
                                <div class="variant-color">
                                    <span class="color-dot" style="background-color: <?= htmlspecialchars($bienThe['MaHex'] ?? '#ffffff') ?>;"></span>
                                    <span><?= htmlspecialchars($bienThe['TenMau']) ?></span>
                                </div>
                            </td>

                            <td><?= htmlspecialchars($bienThe['TenSize']) ?></td>

                            <td><strong><?= htmlspecialchars($bienThe['MaSKU']) ?></strong></td>

                            <td><?= number_format((float) $bienThe['GiaBan'], 0, ',', '.') ?> đ</td>

                            <td><?= number_format((int) $bienThe['SoLuongTon']) ?></td>

                            <td>
                                <?php if ($bienThe['TrangThai'] == 1): ?>
                                    <span class="status status-active">Hoạt động</span>
                                <?php else: ?>
                                    <span class="status status-inactive">Ngừng hoạt động</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="index.php?controller=sanphambienthe&action=edit&id=<?= urlencode($bienThe['MaBienThe']) ?>" class="btn-icon btn-edit" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <a href="index.php?controller=sanphambienthe&action=delete&id=<?= urlencode($bienThe['MaBienThe']) ?>&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn-icon btn-delete" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa biến thể này không?')"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr><td colspan="8" class="empty-data">Sản phẩm chưa có biến thể nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>