<?php

/** @var array $addresses */
/** @var array $cartItems */
/** @var array $phiVanChuyen */
/** @var array $tongTien */
?>
<?php

$tongTien = $tongTien ?? 0;
$phiVanChuyen = $phiVanChuyen ?? 0;
$tienGiam = $tienGiam ?? 0;
$thanhTien = $thanhTien ?? $tongTien;

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Thanh toán - NamShop') ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/checkout.css">


</head>

<body>
    <?php require __DIR__ . '/../home/header.php'; ?>
    <div class="container">



        <main class="checkout-page">

            <h1 class="checkout-title">
                <i class="fa-solid fa-credit-card"></i>
                Thanh toán
            </h1>

            <form action="index.php?controller=dathang&action=store" method="POST">

                <div class="row">

                    <div class="col-lg-8">

                        <!-- ĐỊA CHỈ -->
                        <div class="checkout-box">

                            <div class="checkout-box-title">
                                <i class="fa-solid fa-location-dot"></i>
                                Địa chỉ nhận hàng
                            </div>

                            <?php foreach ($addresses as $index => $address): ?>

                                <label class="checkout-address">

                                    <input type="radio" name="MaDiaChi" value="<?= htmlspecialchars($address['MaDiaChi']) ?>" <?= (($address['MacDinh'] ?? 0) == 1 || $index == 0) ? 'checked' : '' ?>>

                                    <span class="checkout-address-name">
                                        <?= htmlspecialchars($address['HoTenNguoiNhan']) ?>
                                    </span>

                                    <span>
                                        | <?= htmlspecialchars($address['SoDienThoai']) ?>
                                    </span>

                                    <?php if (($address['MacDinh'] ?? 0) == 1): ?>
                                        <span class="checkout-address-default">Mặc định</span>
                                    <?php endif; ?>

                                    <div class="mt-2 text-muted">
                                        <?= htmlspecialchars($address['DiaChiChiTiet']) ?>

                                        <?php if (!empty($address['PhuongXa'])): ?>
                                            , <?= htmlspecialchars($address['PhuongXa']) ?>
                                        <?php endif; ?>

                                        <?php if (!empty($address['QuanHuyen'])): ?>
                                            , <?= htmlspecialchars($address['QuanHuyen']) ?>
                                        <?php endif; ?>

                                        <?php if (!empty($address['TinhThanh'])): ?>
                                            , <?= htmlspecialchars($address['TinhThanh']) ?>
                                        <?php endif; ?>
                                    </div>

                                </label>

                            <?php endforeach; ?>

                            <a href="index.php?controller=diachi&action=index" class="checkout-back">
                                <i class="fa-solid fa-pen"></i>
                                Quản lý địa chỉ
                            </a>

                        </div>

                        <!-- SẢN PHẨM -->
                        <div class="checkout-box">

                            <div class="checkout-box-title">
                                <i class="fa-solid fa-bag-shopping"></i>
                                Sản phẩm
                            </div>

                            <?php foreach ($cartItems as $item): ?>

                                <div class="checkout-product">

                                    <div class="checkout-product-left">

                                        <a href="index.php?controller=sanpham&action=detail&id=<?= urlencode($item['MaSP']) ?>" class="checkout-product-image">

                                            <?php if (!empty($item['HinhAnh'])): ?>

                                                <img src="public/Uploads/products/<?= htmlspecialchars($item['HinhAnh']) ?>" alt="<?= htmlspecialchars($item['TenSP']) ?>">

                                            <?php else: ?>

                                                <div class="checkout-product-no-image">
                                                    <i class="fa-regular fa-image"></i>
                                                </div>

                                            <?php endif; ?>

                                        </a>

                                        <div class="checkout-product-info">

                                            <div class="checkout-product-name">
                                                <?= htmlspecialchars($item['TenSP'] ?? '') ?>
                                            </div>

                                            <div class="checkout-product-option">

                                                <?php if (!empty($item['TenMau'])): ?>
                                                    Màu: <?= htmlspecialchars($item['TenMau']) ?>
                                                <?php endif; ?>

                                                <?php if (!empty($item['TenSize'])): ?>
                                                    | Size: <?= htmlspecialchars($item['TenSize']) ?>
                                                <?php endif; ?>

                                                | Số lượng: <?= (int) ($item['SoLuong'] ?? 0) ?>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="checkout-product-price">
                                        <?= number_format((float) ($item['GiaBan'] ?? 0) * (int) ($item['SoLuong'] ?? 0), 0, ',', '.') ?>đ
                                    </div>

                                </div>

                            <?php endforeach; ?>
                        </div>

                        <!-- THANH TOÁN -->
                        <div class="checkout-box">

                            <div class="checkout-box-title">
                                <i class="fa-solid fa-wallet"></i>
                                Phương thức thanh toán
                            </div>

                            <?php if (!empty($paymentMethods)): ?>

                                <?php foreach ($paymentMethods as $index => $method): ?>

                                    <label class="checkout-payment">

                                        <input type="radio" name="MaPhuongThuc" value="<?= htmlspecialchars($method['MaPhuongThuc']) ?>" <?= $index == 0 ? 'checked' : '' ?>>

                                        <strong>
                                            <?= htmlspecialchars($method['TenPhuongThuc']) ?>
                                        </strong>

                                        <?php if (!empty($method['MoTa'])): ?>
                                            <div class="text-muted mt-1">
                                                <?= htmlspecialchars($method['MoTa']) ?>
                                            </div>
                                        <?php endif; ?>

                                    </label>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <div class="alert alert-warning">
                                    Chưa có phương thức thanh toán.
                                </div>

                            <?php endif; ?>

                        </div>

                        <!-- GHI CHÚ -->
                        <div class="checkout-box">

                            <div class="checkout-box-title">
                                <i class="fa-solid fa-note-sticky"></i>
                                Ghi chú
                            </div>

                            <textarea name="GhiChu" class="checkout-note" placeholder="Ghi chú cho đơn hàng..."></textarea>

                        </div>

                    </div>

                    <!-- TỔNG ĐƠN -->
                    <div class="col-lg-4">

                        <div class="checkout-box">

                            <div class="checkout-box-title">
                                Đơn hàng
                            </div>

                            <div class="checkout-summary-row">
                                <span>Tạm tính</span>
                                <span><?= number_format((float) $tongTien, 0, ',', '.') ?>đ</span>
                            </div>

                            <div class="checkout-summary-row">
                                <span>Phí vận chuyển</span>

                                <span>
                                    <?php if ($phiVanChuyen > 0): ?>
                                        <?= number_format((float) $phiVanChuyen, 0, ',', '.') ?>đ
                                    <?php else: ?>
                                        Miễn phí
                                    <?php endif; ?>
                                </span>
                            </div>

                            <?php if ($tienGiam > 0): ?>

                                <div class="checkout-summary-row">
                                    <span>Giảm giá</span>
                                    <?= number_format((float) $tienGiam, 0, ',', '.') ?>đ
                                </div>

                            <?php endif; ?>

                            <div class="checkout-summary-row checkout-summary-total">
                                <span>Tổng cộng</span>
                                <?= number_format((float) $thanhTien, 0, ',', '.') ?>đ
                            </div>

                            <button type="submit" class="checkout-order-button" <?= empty($paymentMethods) ? 'disabled' : '' ?>>
                                ĐẶT HÀNG
                            </button>

                            <a href="index.php?controller=giohang&action=index" class="checkout-back">
                                <i class="fa-solid fa-arrow-left"></i>
                                Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
    <?php require __DIR__ . '/../home/footer.php'; ?>
</body>

</html>