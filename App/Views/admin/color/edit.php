<?php
/** @var array $mauSac */
?>
<div class="page-title">
    <div>
        <h1>Sửa Màu sắc</h1>
        <p>Cập nhật thông tin màu sắc sản phẩm</p>
    </div>

    <a href="index.php?controller=mausac&action=index" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
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
        <h2>Thông tin Màu sắc</h2>
    </div>

    <form action="index.php?controller=mausac&action=update" method="POST" class="admin-form">

        <input type="hidden" name="MaMau" value="<?= htmlspecialchars($mauSac['MaMau']) ?>">

        <div class="form-group">
            <label>Mã màu</label>
            <input type="text" value="<?= htmlspecialchars($mauSac['MaMau']) ?>" disabled>
        </div>

        <div class="form-group">
            <label for="TenMau">Tên màu <span class="required">*</span></label>
            <input type="text" id="TenMau" name="TenMau" value="<?= htmlspecialchars($mauSac['TenMau']) ?>" required>
        </div>

        <div class="form-group">
            <label for="MaHex">Mã màu Hex</label>

            <div class="color-input-group">
                <input type="color" id="colorPicker" value="<?= htmlspecialchars($mauSac['MaHex'] ?? '#000000') ?>">
                <input type="text" id="MaHex" name="MaHex" value="<?= htmlspecialchars($mauSac['MaHex'] ?? '#000000') ?>" placeholder="#000000">
            </div>
        </div>

        <div class="form-group">
            <label for="TrangThai">Trạng thái</label>

            <select id="TrangThai" name="TrangThai">
                <option value="1" <?= $mauSac['TrangThai'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                <option value="0" <?= $mauSac['TrangThai'] == 0 ? 'selected' : '' ?>>Ngừng hoạt động</option>
            </select>
        </div>

        <div class="form-actions">
            <a href="index.php?controller=mausac&action=index" class="btn btn-light">Hủy</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Cập nhật Màu sắc</button>
        </div>

    </form>
</div>

<script>
    const colorPicker = document.getElementById('colorPicker');
    const maHex = document.getElementById('MaHex');

    colorPicker.addEventListener('input', function () {
        maHex.value = this.value.toUpperCase();
    });

    maHex.addEventListener('input', function () {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            colorPicker.value = this.value;
        }
    });
</script>