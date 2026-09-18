<div class="page-title">
    <div>
        <h1>Quản lý Sản phẩm</h1>
        <p>Danh sách sản phẩm của cửa hàng</p>
    </div>

    <a href="index.php?controller=sanpham&action=create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm Sản phẩm</a>
</div>

<div class="product-tools">
    <a href="index.php?controller=sanpham&action=index" class="btn <?= ($productTab ?? '') == 'sanpham' ? 'btn-dark' : 'btn-dark' ?>"><i class="fa-solid fa-shirt"></i> Sản phẩm</a>
    <a href="index.php?controller=loai&action=index" class="btn <?= ($productTab ?? '') == 'loai' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-list"></i> Danh mục</a>
    <a href="index.php?controller=nhanhieu&action=index" class="btn <?= ($productTab ?? '') == 'nhanhieu' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-tags"></i> Nhãn hiệu</a>
    <a href="index.php?controller=mausac&action=index" class="btn <?= ($productTab ?? '') == 'mausac' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-palette"></i> Màu sắc</a>
    <a href="index.php?controller=size&action=index" class="btn <?= ($productTab ?? '') == 'size' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-ruler"></i> Size</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Danh sách Sản phẩm</h2>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Nhãn hiệu</th>
                    <th>Chất liệu</th>
                    <th>Giới tính</th>
                    <th>Trạng thái</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Biến thể</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dsSanPham)): ?>

                    <?php foreach ($dsSanPham as $sanPham): ?>
                        <tr>
                            <td><?= htmlspecialchars($sanPham['MaSP']) ?></td>
                            <td><strong><?= htmlspecialchars($sanPham['TenSP']) ?></strong></td>
                            <td><?= htmlspecialchars($sanPham['TenLoai']) ?></td>
                            <td><?= htmlspecialchars($sanPham['TenNhanHieu']) ?></td>
                            <td><?= htmlspecialchars($sanPham['ChatLieu'] ?? '') ?></td>
                            <td><?= htmlspecialchars($sanPham['GioiTinh'] ?? '') ?></td>
                            <td>
                                <?php if ($sanPham['TrangThai'] == 1): ?>
                                    <span class="status status-active">Hoạt động</span>
                                <?php else: ?>
                                    <span class="status status-inactive">Ngừng hoạt động</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="product-image-box">
                                    <?php if (!empty($sanPham['AnhChinh'])): ?>
                                        <img src="uploads/products/<?= htmlspecialchars($sanPham['AnhChinh']) ?>" class="product-thumb" alt="<?= htmlspecialchars($sanPham['TenSP']) ?>">
                                    <?php else: ?>
                                        <div class="no-image"><i class="fa-regular fa-image"></i></div>
                                    <?php endif; ?>

                                    <a href="index.php?controller=hinhanhsanpham&action=index&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-light btn-small"><i class="fa-solid fa-images"></i></a>
                                </div>
                            </td>
                            <td>
                                <a href="index.php?controller=sanphambienthe&action=index&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-light"><i class="fa-solid fa-layer-group"></i></a>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="index.php?controller=sanpham&action=edit&id=<?= urlencode($sanPham['MaSP']) ?>" class="btn-icon btn-edit" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <a href="index.php?controller=sanpham&action=delete&id=<?= urlencode($sanPham['MaSP']) ?>" class="btn-icon btn-delete" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="10" class="empty-data">Chưa có sản phẩm nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>