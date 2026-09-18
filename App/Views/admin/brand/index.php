<div class="page-title">
    <div>
        <h1>Quản lý Nhãn hiệu</h1>
        <p>Danh sách nhãn hiệu sản phẩm</p>
    </div>

    <a href="index.php?controller=nhanhieu&action=create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm Nhãn hiệu</a>
</div>

<div class="product-tools">
    <a href="index.php?controller=sanpham&action=index" class="btn <?= ($productTab ?? '') == 'sanpham' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-shirt"></i> Sản phẩm</a>
    <a href="index.php?controller=loai&action=index" class="btn <?= ($productTab ?? '') == 'loai' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-list"></i> Danh mục</a>
    <a href="index.php?controller=nhanhieu&action=index" class="btn <?= ($productTab ?? '') == 'nhanhieu' ? 'btn-dark' : 'btn-dark' ?>"><i class="fa-solid fa-tags"></i> Nhãn hiệu</a>
    <a href="index.php?controller=mausac&action=index" class="btn <?= ($productTab ?? '') == 'mausac' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-palette"></i> Màu sắc</a>
    <a href="index.php?controller=size&action=index" class="btn <?= ($productTab ?? '') == 'size' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-ruler"></i> Size</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Danh sách Nhãn hiệu</h2>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã nhãn hiệu</th>
                    <th>Tên nhãn hiệu</th>
                    <th>Logo</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dsNhanHieu)): ?>

                    <?php foreach ($dsNhanHieu as $nhanHieu): ?>
                        <tr>
                            <td><?= htmlspecialchars($nhanHieu['MaNhanHieu']) ?></td>
                            <td><strong><?= htmlspecialchars($nhanHieu['TenNhanHieu']) ?></strong></td>

                            <td>
                                <?php if (!empty($nhanHieu['Logo'])): ?>
                                    <img src="uploads/brands/<?= htmlspecialchars($nhanHieu['Logo']) ?>" class="brand-logo" alt="<?= htmlspecialchars($nhanHieu['TenNhanHieu']) ?>">
                                <?php else: ?>
                                    <span>Chưa có</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($nhanHieu['MoTa'] ?? '') ?></td>

                            <td>
                                <?php if ($nhanHieu['TrangThai'] == 1): ?>
                                    <span class="status status-active">Hoạt động</span>
                                <?php else: ?>
                                    <span class="status status-inactive">Ngừng hoạt động</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="index.php?controller=nhanhieu&action=edit&id=<?= urlencode($nhanHieu['MaNhanHieu']) ?>" class="btn-icon btn-edit" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <a href="index.php?controller=nhanhieu&action=delete&id=<?= urlencode($nhanHieu['MaNhanHieu']) ?>" class="btn-icon btn-delete" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa nhãn hiệu này không?')"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="empty-data">Chưa có nhãn hiệu nào.</td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>