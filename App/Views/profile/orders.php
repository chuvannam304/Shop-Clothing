<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đơn Mua - NamShop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/home.css">
</head>

<body class="profile-page">

    <div class="container-fluid profile-wrapper">
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <?php require __DIR__ . '/menu.php'; ?>
            </div>

            <div class="col-lg-10 col-md-9">
                <div class="order-page">

                    <div class="order-tabs">
                        <a href="#" class="active">Tất cả</a>
                        <a href="#">Chờ thanh toán</a>
                        <a href="#">Vận chuyển</a>
                        <a href="#">Chờ giao hàng</a>
                        <a href="#">Hoàn thành</a>
                        <a href="#">Đã hủy</a>
                        <a href="#">Trả hàng/Hoàn tiền</a>
                    </div>

                    <div class="order-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Bạn có thể tìm kiếm theo mã đơn hàng hoặc tên sản phẩm">
                    </div>

                    <div class="order-list">

                        <?php if (!empty($donHangs)): ?>

                            <?php foreach ($donHangs as $donHang): ?>

                                <div class="order-item">

                                    <div class="order-item-header">
                                        <div class="order-code">
                                            Đơn hàng:
                                            <strong><?= htmlspecialchars($donHang['MaDonHang']) ?></strong>
                                        </div>

                                        <div class="order-status">
                                            <?= htmlspecialchars($donHang['TrangThai']) ?>
                                        </div>
                                    </div>

                                    <?php if (!empty($donHang['ChiTiet'])): ?>

                                        <?php foreach ($donHang['ChiTiet'] as $sanPham): ?>

                                            <div class="order-product">

                                                <div class="order-product-image">
                                                    <?php if (!empty($sanPham['HinhAnhChinh'])): ?>
                                                        <img src="public/uploads/products/<?= htmlspecialchars($sanPham['HinhAnhChinh']) ?>" alt="<?= htmlspecialchars($sanPham['TenSP']) ?>">
                                                    <?php else: ?>
                                                        <div class="order-no-image">
                                                            <i class="fa-regular fa-image"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="order-product-info">
                                                    <h3><?= htmlspecialchars($sanPham['TenSP']) ?></h3>

                                                    <p>
                                                        Phân loại hàng:
                                                        <?= htmlspecialchars($sanPham['TenMau']) ?>,
                                                        Size <?= htmlspecialchars($sanPham['TenSize']) ?>
                                                    </p>

                                                    <span>x<?= (int) $sanPham['SoLuong'] ?></span>
                                                </div>

                                                <div class="order-product-price">
                                                    <span class="current-price">
                                                        <?= number_format($sanPham['DonGia'], 0, ',', '.') ?>đ
                                                    </span>
                                                </div>

                                            </div>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                    <div class="order-bottom">

                                        <div class="order-date">
                                            <?php if (!empty($donHang['NgayDat'])): ?>
                                                Đặt hàng ngày <?= date('d/m/Y', strtotime($donHang['NgayDat'])) ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="order-summary">
                                            <div class="order-total">
                                                Thành tiền:
                                                <strong><?= number_format($donHang['TongTien'], 0, ',', '.') ?>đ</strong>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <div class="order-empty">
                                <i class="fa-solid fa-box-open"></i>
                                <p>Chưa có đơn hàng</p>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>