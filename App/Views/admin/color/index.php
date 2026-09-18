<div class="page-title">
    <div>
        <h1>Quản lý Màu sắc</h1>
        <p>Danh sách màu sắc sản phẩm</p>
    </div>

    <a href="index.php?controller=mausac&action=create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm Màu sắc</a>
</div>

<div class="product-tools">
    <a href="index.php?controller=sanpham&action=index" class="btn <?= ($productTab ?? '') == 'sanpham' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-shirt"></i> Sản phẩm</a>
    <a href="index.php?controller=loai&action=index" class="btn <?= ($productTab ?? '') == 'loai' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-list"></i> Danh mục</a>
    <a href="index.php?controller=nhanhieu&action=index" class="btn <?= ($productTab ?? '') == 'nhanhieu' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-tags"></i> Nhãn hiệu</a>
    <a href="index.php?controller=mausac&action=index" class="btn <?= ($productTab ?? '') == 'mausac' ? 'btn-dark' : 'btn-dark' ?>"><i class="fa-solid fa-palette"></i> Màu sắc</a>
    <a href="index.php?controller=size&action=index" class="btn <?= ($productTab ?? '') == 'size' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-ruler"></i> Size</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Danh sách Màu sắc</h2>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã màu</th>
                    <th>Tên màu</th>
                    <th>Màu</th>
                    <th>Mã Hex</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dsMauSac)): ?>

                    <?php foreach ($dsMauSac as $mau): ?>
                        <tr>
                            <td><?= htmlspecialchars($mau['MaMau']) ?></td>

                            <td><strong><?= htmlspecialchars($mau['TenMau']) ?></strong></td>

                            <td>
                                <span class="color-preview" style="background: <?= htmlspecialchars($mau['MaHex'] ?? '#ffffff') ?>;"></span>
                            </td>

                            <td><?= htmlspecialchars($mau['MaHex'] ?? '') ?></td>

                            <td>
                                <?php if ($mau['TrangThai'] == 1): ?>
                                    <span class="status status-active">Hoạt động</span>
                                <?php else: ?>
                                    <span class="status status-inactive">Ngừng hoạt động</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="index.php?controller=mausac&action=edit&id=<?= urlencode($mau['MaMau']) ?>" class="btn-icon btn-edit" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <a href="index.php?controller=mausac&action=delete&id=<?= urlencode($mau['MaMau']) ?>" class="btn-icon btn-delete" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa màu này không?')"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="empty-data">Chưa có màu sắc nào.</td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>