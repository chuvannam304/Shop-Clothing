<?php

/** @var array $cartItems */
/** @var float|int $tongTien */

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Giỏ hàng') ?> - NamShop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/giohang.css">

</head>

<body>
    <?php require __DIR__ . '/../home/header.php'; ?>
    <div class="container">
        <main class="cart-page">

            <div class="cart-heading">

                <h1>GIỎ HÀNG</h1>

                <span id="cartProductCount">
                    <?= count($cartItems) ?> sản phẩm
                </span>

            </div>


            <?php if (isset($_SESSION['cart_success'])): ?>

                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['cart_success']) ?>
                </div>

                <?php unset($_SESSION['cart_success']); ?>

            <?php endif; ?>


            <?php if (!empty($cartItems)): ?>

                <div class="cart-layout">

                    <!-- DANH SÁCH SẢN PHẨM -->
                    <div class="cart-products">

                        <?php foreach ($cartItems as $item): ?>

                            <?php
                            $thanhTien = (float) $item['GiaBan'] * (int) $item['SoLuong'];
                            ?>

                            <div class="cart-item" data-cart-item="<?= htmlspecialchars($item['MaCTGH']) ?>" data-stock="<?= (int) $item['SoLuongTon'] ?>">
                                <button type="button" class="cart-remove-x" data-id="<?= htmlspecialchars($item['MaCTGH']) ?>" title="Xóa khỏi giỏ hàng"><i class="fa-solid fa-xmark"></i></button>
                                <!-- ẢNH -->
                                <a href="index.php?controller=sanpham&action=detail&id=<?= urlencode($item['MaSP']) ?>" class="cart-item-image">

                                    <?php if (!empty($item['HinhAnh'])): ?>

                                        <img src="public/Uploads/products/<?= htmlspecialchars($item['HinhAnh']) ?>" alt="<?= htmlspecialchars($item['TenSP']) ?>">

                                    <?php else: ?>

                                        <div class="cart-no-image">
                                            <i class="fa-regular fa-image"></i>
                                        </div>

                                    <?php endif; ?>

                                </a>


                                <!-- THÔNG TIN -->
                                <div class="cart-item-info">

                                    <h3>

                                        <a href="index.php?controller=sanpham&action=detail&id=<?= urlencode($item['MaSP']) ?>">
                                            <?= htmlspecialchars($item['TenSP']) ?>
                                        </a>

                                    </h3>

                                    <div class="cart-item-variant">

                                        <span>
                                            Màu:
                                            <strong>
                                                <?= htmlspecialchars($item['TenMau']) ?>
                                            </strong>
                                        </span>

                                        <span>
                                            Size:
                                            <strong>
                                                <?= htmlspecialchars($item['TenSize']) ?>
                                            </strong>
                                        </span>

                                    </div>

                                    <div class="cart-item-price">
                                        <?= number_format((float) $item['GiaBan'], 0, ',', '.') ?>đ
                                    </div>

                                </div>


                                <!-- SỐ LƯỢNG -->
                                <div class="cart-item-quantity">

                                    <span class="cart-label">
                                        Số lượng
                                    </span>

                                    <div class="cart-quantity-control">

                                        <button type="button" class="cart-quantity-minus" <?= (int) $item['SoLuong'] <= 1 ? 'disabled' : '' ?>>
                                            <i class="fa-solid fa-minus"></i>
                                        </button>

                                        <input type="number" class="cart-quantity-input" value="<?= (int) $item['SoLuong'] ?>" readonly>

                                        <button type="button" class="cart-quantity-plus" <?= (int) $item['SoLuong'] >= (int) $item['SoLuongTon'] ? 'disabled' : '' ?>>
                                            <i class="fa-solid fa-plus"></i>
                                        </button>

                                    </div>

                                    <?php if ((int) $item['SoLuongTon'] < (int) $item['SoLuong']): ?>

                                        <small class="cart-stock-warning">
                                            Chỉ còn <?= (int) $item['SoLuongTon'] ?> sản phẩm
                                        </small>

                                    <?php endif; ?>

                                </div>


                                <!-- THÀNH TIỀN -->
                                <div class="cart-item-total">

                                    <span class="cart-label">
                                        Thành tiền
                                    </span>

                                    <strong class="cart-item-total-value">
                                        <?= number_format($thanhTien, 0, ',', '.') ?>đ
                                    </strong>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>


                    <!-- TỔNG ĐƠN -->
                    <aside class="cart-summary">

                        <h2>TÓM TẮT ĐƠN HÀNG</h2>

                        <div class="cart-summary-row">

                            <span>Tạm tính</span>

                            <strong id="cartSubtotal">
                                <?= number_format((float) $tongTien, 0, ',', '.') ?>đ
                            </strong>

                        </div>

                        <div class="cart-summary-row">

                            <span>Phí vận chuyển</span>

                            <span>
                                Tính khi thanh toán
                            </span>

                        </div>

                        <div class="cart-summary-total">

                            <span>Tổng tiền</span>

                            <strong id="cartTotal">
                                <?= number_format((float) $tongTien, 0, ',', '.') ?>đ
                            </strong>
                        </div>

                        <button type="button" class="cart-checkout-button" onclick="window.location.href='index.php?controller=dathang&action=index'">
                            TIẾN HÀNH ĐẶT HÀNG
                        </button>
                        <a href="index.php?controller=home&action=index" class="cart-continue-shopping">
                            <i class="fa-solid fa-arrow-left"></i>
                            Tiếp tục mua sắm
                        </a>

                    </aside>

                </div>


            <?php else: ?>

                <!-- GIỎ HÀNG TRỐNG -->
                <div class="empty-cart">

                    <div class="empty-cart-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>

                    <h2>Giỏ hàng của bạn đang trống</h2>

                    <p>
                        Hãy chọn sản phẩm bạn yêu thích và thêm vào giỏ hàng.
                    </p>

                    <a href="index.php?controller=home&action=index">
                        TIẾP TỤC MUA SẮM
                    </a>

                </div>

            <?php endif; ?>

        </main>
        <!-- MODAL XÁC NHẬN XÓA SẢN PHẨM -->
        <div class="cart-delete-modal" id="cartDeleteModal">
            <div class="cart-delete-modal-box">
                <div class="cart-delete-modal-icon">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h3>Xóa sản phẩm?</h3>
                <p>Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?</p>
                <div class="cart-delete-modal-actions">
                    <button type="button" class="cart-delete-cancel" id="cartDeleteCancel">Hủy</button>
                    <button type="button" class="cart-delete-confirm" id="cartDeleteConfirm">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <?php require __DIR__ . '/../home/footer.php'; ?>
    <script src="public/js/script.js"></script>
</body>

</html>