<?php
/** @var array $sanPham */
/** @var array $hinhAnh */
?>

<div class="page-title">
    <div>
        <h1>Sửa Hình ảnh</h1>
        <p><?= htmlspecialchars($sanPham['MaSP']) ?> - <?= htmlspecialchars($sanPham['TenSP']) ?></p>
    </div>

    <a href="index.php?controller=hinhanhsanpham&action=index&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Thông tin Hình ảnh</h2>
    </div>

    <form action="index.php?controller=hinhanhsanpham&action=update" method="POST" enctype="multipart/form-data" class="admin-form">

        <input type="hidden" name="MaHinh" value="<?= htmlspecialchars($hinhAnh['MaHinh']) ?>">

        <div class="form-group">
            <label>Mã hình</label>
            <input type="text" value="<?= htmlspecialchars($hinhAnh['MaHinh']) ?>" disabled>
        </div>

        <div class="form-group">
            <label>Sản phẩm</label>
            <input type="text" value="<?= htmlspecialchars($sanPham['MaSP']) ?> - <?= htmlspecialchars($sanPham['TenSP']) ?>" disabled>
        </div>

        <div class="form-group">
            <label>Hình ảnh hiện tại</label>

            <div class="current-product-image">
                <img src="public/uploads/products/<?= htmlspecialchars($hinhAnh['DuongDan']) ?>" alt="Hình sản phẩm">
            </div>
        </div>

        <div class="form-group">
            <label for="HinhAnh">Thay hình ảnh mới</label>
            <input type="file" id="HinhAnh" name="HinhAnh" accept=".jpg,.jpeg,.png,.webp">
            <small class="form-note">Không chọn ảnh mới nếu muốn giữ ảnh hiện tại. Tối đa 5MB.</small>
        </div>

        <div class="form-group">
            <label for="LaAnhChinh">Loại hình ảnh</label>
            <select id="LaAnhChinh" name="LaAnhChinh">
                <option value="0" <?= $hinhAnh['LaAnhChinh'] == 0 ? 'selected' : '' ?>>Ảnh phụ</option>
                <option value="1" <?= $hinhAnh['LaAnhChinh'] == 1 ? 'selected' : '' ?>>Ảnh chính</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ThuTu">Thứ tự hiển thị</label>
            <input type="number" id="ThuTu" name="ThuTu" min="1" value="<?= htmlspecialchars($hinhAnh['ThuTu']) ?>">
        </div>

        <div class="form-actions">
            <a href="index.php?controller=hinhanhsanpham&action=index&sp=<?= urlencode($sanPham['MaSP']) ?>" class="btn btn-light">Hủy</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Cập nhật Hình ảnh</button>
        </div>

    </form>
</div>