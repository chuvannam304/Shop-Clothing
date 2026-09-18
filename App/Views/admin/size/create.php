<div class="page-title">
    <div>
        <h1>Thêm Size</h1>
        <p>Thêm kích thước mới cho sản phẩm</p>
    </div>

    <a href="index.php?controller=size&action=index" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
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
        <h2>Thông tin Size</h2>
    </div>

    <form action="index.php?controller=size&action=store" method="POST" class="admin-form">

        <div class="form-group">
            <label for="TenSize">Tên Size <span class="required">*</span></label>
            <input type="text" id="TenSize" name="TenSize" placeholder="Ví dụ: S, M, L, XL..." required>
        </div>

        <div class="form-group">
            <label for="MoTa">Mô tả</label>
            <textarea id="MoTa" name="MoTa" rows="4" placeholder="Nhập mô tả size..."></textarea>
        </div>


        <div class="form-actions">
            <a href="index.php?controller=size&action=index" class="btn btn-light">Hủy</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Lưu Size</button>
        </div>

    </form>
</div>