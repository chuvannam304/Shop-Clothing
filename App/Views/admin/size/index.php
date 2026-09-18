<div class="page-title">
    <div>
        <h1>Quản lý Size</h1>
        <p>Danh sách kích thước sản phẩm</p>
    </div>

    <a href="index.php?controller=size&action=create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm Size</a>
</div>

<div class="product-tools">
    <a href="index.php?controller=sanpham&action=index" class="btn btn-light"><i class="fa-solid fa-shirt"></i> Sản phẩm</a>
    <a href="index.php?controller=loai&action=index" class="btn btn-light"><i class="fa-solid fa-list"></i> Danh mục</a>
    <a href="index.php?controller=nhanhieu&action=index" class="btn btn-light"><i class="fa-solid fa-tags"></i> Nhãn hiệu</a>
    <a href="index.php?controller=mausac&action=index" class="btn btn-light"><i class="fa-solid fa-palette"></i> Màu sắc</a>
    <a href="index.php?controller=size&action=index" class="btn btn-dark"><i class="fa-solid fa-ruler"></i> Size</a>
</div>

<div class="card">

    <div class="card-header">
        <h2>Danh sách Size</h2>
    </div>

    <div class="table-responsive">
        <table class="admin-table">

            <thead>
                <tr>
                    <th>Mã Size</th>
                    <th>Tên Size</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($dsSize)): ?>

                    <?php foreach ($dsSize as $size): ?>

                        <tr>
                            <td><?= htmlspecialchars($size['MaSize']) ?></td>

                            <td><strong><?= htmlspecialchars($size['TenSize']) ?></strong></td>

                            <td><?= htmlspecialchars($size['MoTa'] ?? '') ?></td>

                          

                            <td>
                                <div class="action-buttons">

                                    <a href="index.php?controller=size&action=edit&id=<?= urlencode($size['MaSize']) ?>" class="btn-icon btn-edit" title="Sửa">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <a href="index.php?controller=size&action=delete&id=<?= urlencode($size['MaSize']) ?>"
                                       class="btn-icon btn-delete"
                                       title="Xóa"
                                       onclick="return confirm('Bạn có chắc muốn xóa size này không?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" class="empty-data">Chưa có size nào.</td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>