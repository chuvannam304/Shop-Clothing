<?php
/** @var array $sanPham */
/** @var array $dsLoai */
/** @var array $dsNhanHieu */
?>

<div class="page-title">
    <div>
        <h1>Sửa Sản phẩm</h1>
        <p>Cập nhật thông tin sản phẩm</p>
    </div>

    <a href="index.php?controller=sanpham&action=index" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
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
        <h2>Thông tin Sản phẩm</h2>
    </div>

    <form action="index.php?controller=sanpham&action=update" method="POST" class="admin-form">

        <input type="hidden" name="MaSP" value="<?= htmlspecialchars($sanPham['MaSP']) ?>">

        <div class="form-group">
            <label>Mã sản phẩm</label>
            <input type="text" value="<?= htmlspecialchars($sanPham['MaSP']) ?>" disabled>
        </div>

        <div class="form-group">
            <label for="TenSP">Tên sản phẩm <span class="required">*</span></label>
            <input type="text" id="TenSP" name="TenSP" value="<?= htmlspecialchars($sanPham['TenSP']) ?>" required>
        </div>

        <div class="form-group">
            <label for="MaLoai">Danh mục <span class="required">*</span></label>

            <select id="MaLoai" name="MaLoai" required>
                <option value="">-- Chọn danh mục --</option>

                <?php foreach ($dsLoai as $loai): ?>
                    <option value="<?= htmlspecialchars($loai['MaLoai']) ?>" <?= $sanPham['MaLoai'] == $loai['MaLoai'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($loai['TenLoai']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="MaNhanHieu">Nhãn hiệu <span class="required">*</span></label>

            <select id="MaNhanHieu" name="MaNhanHieu" required>
                <option value="">-- Chọn nhãn hiệu --</option>

                <?php foreach ($dsNhanHieu as $nhanHieu): ?>
                    <option value="<?= htmlspecialchars($nhanHieu['MaNhanHieu']) ?>" <?= $sanPham['MaNhanHieu'] == $nhanHieu['MaNhanHieu'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($nhanHieu['TenNhanHieu']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="ChatLieu">Chất liệu</label>
            <input type="text" id="ChatLieu" name="ChatLieu" value="<?= htmlspecialchars($sanPham['ChatLieu'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="GioiTinh">Giới tính</label>

            <select id="GioiTinh" name="GioiTinh">
                <option value="">-- Chọn giới tính --</option>
                <option value="Nam" <?= ($sanPham['GioiTinh'] ?? '') == 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= ($sanPham['GioiTinh'] ?? '') == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                <option value="Unisex" <?= ($sanPham['GioiTinh'] ?? '') == 'Unisex' ? 'selected' : '' ?>>Unisex</option>
            </select>
        </div>

        <div class="form-group">
            <label for="MoTa">Mô tả</label>
            <textarea id="MoTa" name="MoTa" rows="5"><?= htmlspecialchars($sanPham['MoTa'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="TrangThai">Trạng thái</label>

            <select id="TrangThai" name="TrangThai">
                <option value="1" <?= $sanPham['TrangThai'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                <option value="0" <?= $sanPham['TrangThai'] == 0 ? 'selected' : '' ?>>Ngừng hoạt động</option>
            </select>
        </div>

        <div class="form-actions">
            <a href="index.php?controller=sanpham&action=index" class="btn btn-light">Hủy</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Cập nhật Sản phẩm</button>
        </div>

    </form>
</div>