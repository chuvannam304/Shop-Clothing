<div class="page-title">
    <div>
        <h1>Quản lý Danh mục</h1>
        <p>Danh sách danh mục sản phẩm</p>
    </div>

    <a href="index.php?controller=loai&action=create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm Danh mục</a>
</div>

<div class="product-tools">
    <a href="index.php?controller=sanpham&action=index" class="btn <?= ($productTab ?? '') == 'sanpham' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-shirt"></i> Sản phẩm</a>
    <a href="index.php?controller=loai&action=index" class="btn <?= ($productTab ?? '') == 'loai' ? 'btn-dark' : 'btn-dark' ?>"><i class="fa-solid fa-list"></i> Danh mục</a>
    <a href="index.php?controller=nhanhieu&action=index" class="btn <?= ($productTab ?? '') == 'nhanhieu' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-tags"></i> Nhãn hiệu</a>
    <a href="index.php?controller=mausac&action=index" class="btn <?= ($productTab ?? '') == 'mausac' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-palette"></i> Màu sắc</a>
    <a href="index.php?controller=size&action=index" class="btn <?= ($productTab ?? '') == 'size' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-ruler"></i> Size</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Danh sách Danh mục</h2>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã loại</th>
                    <th>Tên loại</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dsLoai)): ?>

                    <?php foreach ($dsLoai as $loai): ?>
                        <tr>
                            <td><?= htmlspecialchars($loai['MaLoai']) ?></td>
                            <td><strong><?= htmlspecialchars($loai['TenLoai']) ?></strong></td>
                            <td><?= htmlspecialchars($loai['MoTa'] ?? '') ?></td>

                            <td>
                                <?php if ($loai['TrangThai'] == 1): ?>
                                    <span class="status status-active">Hoạt động</span>
                                <?php else: ?>
                                    <span class="status status-inactive">Ngừng hoạt động</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="index.php?controller=loai&action=edit&id=<?= urlencode($loai['MaLoai']) ?>" class="btn-icon btn-edit" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="index.php?controller=loai&action=delete&id=<?= urlencode($loai['MaLoai']) ?>" class="btn-icon btn-delete" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?')"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr><td colspan="5" class="empty-data">Chưa có danh mục nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>