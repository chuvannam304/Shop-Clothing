<?php
/** @var array $nhanHieu */
?>
<div class="page-title">
    <div>
        <h1>Sửa Nhãn hiệu</h1>
        <p>Cập nhật thông tin nhãn hiệu sản phẩm</p>
    </div>

    <a href="index.php?controller=nhanhieu&action=index" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
</div>

<div class="product-tools">
    <a href="index.php?controller=sanpham&action=index" class="btn <?= ($productTab ?? '') == 'sanpham' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-shirt"></i> Sản phẩm</a>
    <a href="index.php?controller=loai&action=index" class="btn <?= ($productTab ?? '') == 'loai' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-list"></i> Danh mục</a>
    <a href="index.php?controller=nhanhieu&action=index" class="btn <?= ($productTab ?? '') == 'nhanhieu' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-tags"></i> Nhãn hiệu</a>
    <a href="index.php?controller=mausac&action=index" class="btn <?= ($productTab ?? '') == 'mausac' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-palette"></i> Màu sắc</a>
    <a href="index.php?controller=size&action=index" class="btn <?= ($productTab ?? '') == 'size' ? 'btn-dark' : 'btn-light' ?>"><i class="fa-solid fa-ruler"></i> Size</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Thông tin Nhãn hiệu</h2>
    </div>

    <form action="index.php?controller=nhanhieu&action=update" method="POST" enctype="multipart/form-data" class="admin-form">

        <input type="hidden" name="MaNhanHieu" value="<?= htmlspecialchars($nhanHieu['MaNhanHieu']) ?>">

        <div class="form-group">
            <label>Mã nhãn hiệu</label>
            <input type="text" value="<?= htmlspecialchars($nhanHieu['MaNhanHieu']) ?>" disabled>
        </div>

        <div class="form-group">
            <label for="TenNhanHieu">Tên nhãn hiệu <span class="required">*</span></label>
            <input type="text" id="TenNhanHieu" name="TenNhanHieu" value="<?= htmlspecialchars($nhanHieu['TenNhanHieu']) ?>" required>
        </div>

        <div class="form-group">
            <label>Logo hiện tại</label>

            <?php if (!empty($nhanHieu['Logo'])): ?>
                <img src="uploads/brands/<?= htmlspecialchars($nhanHieu['Logo']) ?>" class="brand-logo-edit" alt="Logo">
            <?php else: ?>
                <p>Chưa có logo</p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="Logo">Chọn logo mới</label>
            <input type="file" id="Logo" name="Logo" accept=".jpg,.jpeg,.png,.webp">
            <small class="form-note">Không chọn ảnh mới thì logo hiện tại sẽ được giữ nguyên.</small>
        </div>

        <div class="form-group">
            <label for="MoTa">Mô tả</label>
            <textarea id="MoTa" name="MoTa" rows="4"><?= htmlspecialchars($nhanHieu['MoTa'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="TrangThai">Trạng thái</label>
            <select id="TrangThai" name="TrangThai">
                <option value="1" <?= $nhanHieu['TrangThai'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                <option value="0" <?= $nhanHieu['TrangThai'] == 0 ? 'selected' : '' ?>>Ngừng hoạt động</option>
            </select>
        </div>

        <div class="form-actions">
            <a href="index.php?controller=nhanhieu&action=index" class="btn btn-light">Hủy</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Cập nhật Nhãn hiệu</button>
        </div>

    </form>
</div>