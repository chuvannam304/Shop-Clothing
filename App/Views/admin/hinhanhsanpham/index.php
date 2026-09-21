<?php
/** @var array $sanPham */
/** @var array $dsHinhAnh */
?>

<div class="page-title">
    <div>
        <h1>Hình ảnh Sản phẩm</h1>
        <p><?= htmlspecialchars($sanPham['MaSP']) ?> - <?= htmlspecialchars($sanPham['TenSP']) ?></p>
    </div>

    <a href="index.php?controller=hinhanhsanpham&action=create&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm Hình ảnh</a>
</div>

<div class="product-tools">
    <a href="index.php?controller=sanpham&action=index" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại Sản phẩm</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Danh sách Hình ảnh</h2>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã hình</th>
                    <th>Hình ảnh</th>
                    <th>Tên file</th>
                    <th>Ảnh chính</th>
                    <th>Thứ tự</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dsHinhAnh)): ?>

                    <?php foreach ($dsHinhAnh as $hinhAnh): ?>
                        <tr>
                            <td><?= htmlspecialchars($hinhAnh['MaHinh']) ?></td>

                            <td>
                                <img src="public/uploads/products/<?= htmlspecialchars($hinhAnh['DuongDan']) ?>" class="product-image-preview" alt="Hình sản phẩm">
                            </td>

                            <td><?= htmlspecialchars($hinhAnh['DuongDan']) ?></td>

                            <td>
                                <?php if ($hinhAnh['LaAnhChinh'] == 1): ?>
                                    <span class="status status-active">Ảnh chính</span>
                                <?php else: ?>
                                    <span class="status status-inactive">Ảnh phụ</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($hinhAnh['ThuTu']) ?></td>

                            <td>
                                <div class="action-buttons">
                                    <a href="index.php?controller=hinhanhsanpham&action=edit&id=<?= urlencode($hinhAnh['MaHinh']) ?>" class="btn-icon btn-edit" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <a href="index.php?controller=hinhanhsanpham&action=delete&id=<?= urlencode($hinhAnh['MaHinh']) ?>" class="btn-icon btn-delete" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa hình ảnh này không?')"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr><td colspan="6" class="empty-data">Sản phẩm chưa có hình ảnh nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>