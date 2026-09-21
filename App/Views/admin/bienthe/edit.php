<?php
/** @var array $sanPham */
/** @var array $bienThe */
/** @var array $dsMau */
/** @var array $dsSize */
?>

<div class="page-title">
    <div>
        <h1>Sửa Biến thể</h1>
        <p><?= htmlspecialchars($sanPham['MaSP']) ?> - <?= htmlspecialchars($sanPham['TenSP']) ?></p>
    </div>

    <a href="index.php?controller=sanphambienthe&action=index&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Thông tin Biến thể</h2>
    </div>

    <form action="index.php?controller=sanphambienthe&action=update" method="POST" class="admin-form">

        <input type="hidden" name="MaBienThe" value="<?= htmlspecialchars($bienThe['MaBienThe']) ?>">
        <input type="hidden" name="MaSP" value="<?= htmlspecialchars($bienThe['MaSP']) ?>">

        <div class="form-group">
            <label>Mã biến thể</label>
            <input type="text" value="<?= htmlspecialchars($bienThe['MaBienThe']) ?>" disabled>
        </div>

        <div class="form-group">
            <label>Sản phẩm</label>
            <input type="text" value="<?= htmlspecialchars($sanPham['MaSP']) ?> - <?= htmlspecialchars($sanPham['TenSP']) ?>" disabled>
        </div>

        <div class="form-group">
            <label for="MaMau">Màu sắc <span class="required">*</span></label>
            <select id="MaMau" name="MaMau" required>
                <option value="">-- Chọn màu sắc --</option>

                <?php foreach ($dsMau as $mau): ?>
                    <option value="<?= htmlspecialchars($mau['MaMau']) ?>" <?= $bienThe['MaMau'] == $mau['MaMau'] ? 'selected' : '' ?>><?= htmlspecialchars($mau['TenMau']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="MaSize">Size <span class="required">*</span></label>
            <select id="MaSize" name="MaSize" required>
                <option value="">-- Chọn size --</option>

                <?php foreach ($dsSize as $size): ?>
                    <option value="<?= htmlspecialchars($size['MaSize']) ?>" <?= $bienThe['MaSize'] == $size['MaSize'] ? 'selected' : '' ?>><?= htmlspecialchars($size['TenSize']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="MaSKU">SKU <span class="required">*</span></label>
            <input type="text" id="MaSKU" name="MaSKU" value="<?= htmlspecialchars($bienThe['MaSKU']) ?>" required>
        </div>

        <div class="form-group">
            <label for="GiaBan">Giá bán <span class="required">*</span></label>
            <input type="number" id="GiaBan" name="GiaBan" min="0" step="1000" value="<?= htmlspecialchars($bienThe['GiaBan']) ?>" required>
        </div>

        <div class="form-group">
            <label for="SoLuongTon">Số lượng tồn <span class="required">*</span></label>
            <input type="number" id="SoLuongTon" name="SoLuongTon" min="0" value="<?= htmlspecialchars($bienThe['SoLuongTon']) ?>" required>
        </div>

        <div class="form-group">
            <label for="TrangThai">Trạng thái</label>
            <select id="TrangThai" name="TrangThai">
                <option value="1" <?= $bienThe['TrangThai'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                <option value="0" <?= $bienThe['TrangThai'] == 0 ? 'selected' : '' ?>>Ngừng hoạt động</option>
            </select>
        </div>

        <div class="form-actions">
            <a href="index.php?controller=sanphambienthe&action=index&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-light">Hủy</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Cập nhật Biến thể</button>
        </div>

    </form>
</div>