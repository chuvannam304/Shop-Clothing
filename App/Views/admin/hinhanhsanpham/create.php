<?php
/** @var array $sanPham */
?>

<div class="page-title">
    <div>
        <h1>Thêm Hình ảnh</h1>
        <p><?= htmlspecialchars($sanPham['MaSP']) ?> - <?= htmlspecialchars($sanPham['TenSP']) ?></p>
    </div>

    <a href="index.php?controller=hinhanhsanpham&action=index&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Thông tin Hình ảnh</h2>
    </div>

    <form action="index.php?controller=hinhanhsanpham&action=store" method="POST" enctype="multipart/form-data" class="admin-form">

        <input type="hidden" name="MaSP" value="<?= htmlspecialchars($sanPham['MaSP']) ?>">

        <div class="form-group">
            <label>Sản phẩm</label>
            <input type="text" value="<?= htmlspecialchars($sanPham['MaSP']) ?> - <?= htmlspecialchars($sanPham['TenSP']) ?>" disabled>
        </div>

        <div class="form-group">
            <label for="HinhAnh">Hình ảnh <span class="required">*</span></label>
            <input type="file" id="HinhAnh" name="HinhAnh" accept=".jpg,.jpeg,.png,.webp" required>
            <small class="form-note">Cho phép JPG, JPEG, PNG, WEBP. Tối đa 5MB.</small>
        </div>

        <div class="form-group">
            <label for="LaAnhChinh">Loại hình ảnh</label>
            <select id="LaAnhChinh" name="LaAnhChinh">
                <option value="0">Ảnh phụ</option>
                <option value="1">Ảnh chính</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ThuTu">Thứ tự hiển thị</label>
            <input type="number" id="ThuTu" name="ThuTu" min="1" value="1">
        </div>

        <div class="form-actions">
            <a href="index.php?controller=hinhanhsanpham&action=index&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-light">Hủy</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Lưu Hình ảnh</button>
        </div>

    </form>
</div>