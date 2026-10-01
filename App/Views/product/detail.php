<?php

/** @var array $sanPham */
/** @var array $hinhAnhs */
/** @var array $bienThes */
/** @var array|null $bienTheMacDinh */
/** @var array $sanPhamCungLoai */

?>
<?php

$bienTheMacDinh = !empty($bienThes) ? $bienThes[0] : null;

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Chi tiết sản phẩm') ?> - NamShop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/chitietsp.css">

</head>

<body>

    <div class="container">

        <?php require __DIR__ . '/../home/header.php'; ?>

        <main class="product-detail-page">

            <!-- CHI TIẾT SẢN PHẨM -->
            <section class="product-detail">

                <!-- ẢNH -->
                <div class="product-detail-gallery">

                    <div class="product-thumbnails">

                        <?php if (!empty($hinhAnhs)): ?>

                            <?php foreach ($hinhAnhs as $index => $hinhAnh): ?>

                                <button type="button" class="product-thumbnail <?= $index === 0 ? 'active' : '' ?>" data-image="public/Uploads/products/<?= htmlspecialchars($hinhAnh['DuongDan']) ?>">

                                    <img src="public/Uploads/products/<?= htmlspecialchars($hinhAnh['DuongDan']) ?>" alt="<?= htmlspecialchars($sanPham['TenSP']) ?>">

                                </button>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>

                    <div class="product-main-image">

                        <?php if (!empty($hinhAnhs)): ?>

                            <img id="mainProductImage" src="public/Uploads/products/<?= htmlspecialchars($hinhAnhs[0]['DuongDan']) ?>" alt="<?= htmlspecialchars($sanPham['TenSP']) ?>">

                        <?php else: ?>

                            <div class="product-detail-no-image">
                                <i class="fa-regular fa-image"></i>
                                <span>Chưa có hình ảnh</span>
                            </div>

                        <?php endif; ?>

                    </div>

                </div>


                <!-- THÔNG TIN -->
                <div class="product-detail-info">

                    <h1><?= htmlspecialchars($sanPham['TenSP']) ?></h1>

                    <div class="product-detail-status">

                        <?php if ($bienTheMacDinh && (int) $bienTheMacDinh['SoLuongTon'] > 0): ?>

                            <span class="in-stock" id="productStatus">
                                <i class="fa-solid fa-circle-check"></i>
                                Còn hàng
                            </span>

                        <?php else: ?>

                            <span class="out-stock" id="productStatus">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Hết hàng
                            </span>

                        <?php endif; ?>

                        <!-- <span class="product-code">
                            Mã sản phẩm: <?= htmlspecialchars($sanPham['MaSP']) ?>
                        </span> -->

                    </div>


                    <!-- GIÁ -->
                    <div class="product-detail-price" id="productPrice">

                        <?php if ($bienTheMacDinh): ?>

                            <?= number_format((float) $bienTheMacDinh['GiaBan'], 0, ',', '.') ?>đ

                        <?php else: ?>

                            Chưa có giá

                        <?php endif; ?>

                    </div>


                    <!-- MÀU SẮC -->
                    <div class="product-option">

                        <div class="product-option-title">
                            Màu sắc:
                            <strong id="selectedColorName">
                                <?= htmlspecialchars($bienTheMacDinh['TenMau'] ?? '') ?>
                            </strong>
                        </div>

                        <div class="product-colors">

                            <?php
                            $mauSacs = [];

                            foreach ($bienThes as $bienThe) {

                                if (!isset($mauSacs[$bienThe['MaMau']])) {

                                    $mauSacs[$bienThe['MaMau']] = [
                                        'TenMau' => $bienThe['TenMau'],
                                        'MaHex' => $bienThe['MaHex']
                                    ];
                                }
                            }
                            ?>

                            <?php foreach ($mauSacs as $maMau => $mau): ?>

                                <button type="button" class="product-color-option <?= ($bienTheMacDinh && $maMau == $bienTheMacDinh['MaMau']) ? 'active' : '' ?>" data-color="<?= htmlspecialchars($maMau) ?>" data-name="<?= htmlspecialchars($mau['TenMau']) ?>" title="<?= htmlspecialchars($mau['TenMau']) ?>">

                                    <span style="background-color: <?= htmlspecialchars($mau['MaHex'] ?: '#ffffff') ?>;"></span>

                                </button>

                            <?php endforeach; ?>

                        </div>

                    </div>


                    <!-- SIZE -->
                    <div class="product-option">

                        <div class="product-option-title">
                            Kích thước:
                            <strong id="selectedSizeName">
                                <?= htmlspecialchars($bienTheMacDinh['TenSize'] ?? '') ?>
                            </strong>
                        </div>

                        <div class="product-sizes" id="productSizes">

                            <?php
                            $sizes = [];

                            foreach ($bienThes as $bienThe) {

                                if (!isset($sizes[$bienThe['MaSize']])) {
                                    $sizes[$bienThe['MaSize']] = $bienThe['TenSize'];
                                }
                            }
                            ?>

                            <?php foreach ($sizes as $maSize => $tenSize): ?>

                                <button type="button" class="product-size-option <?= ($bienTheMacDinh && $maSize == $bienTheMacDinh['MaSize']) ? 'active' : '' ?>" data-size="<?= htmlspecialchars($maSize) ?>">

                                    <?= htmlspecialchars($tenSize) ?>

                                </button>

                            <?php endforeach; ?>

                        </div>

                    </div>


                    <!-- TỒN KHO -->
                    <div class="product-stock-info" id="productStockInfo">

                        <?php if ($bienTheMacDinh): ?>

                            <?php if ((int) $bienTheMacDinh['SoLuongTon'] > 0): ?>

                                Còn <?= (int) $bienTheMacDinh['SoLuongTon'] ?> sản phẩm

                            <?php else: ?>

                                Hết hàng

                            <?php endif; ?>

                        <?php else: ?>

                            Chưa có biến thể sản phẩm

                        <?php endif; ?>

                    </div>


                    <!-- SỐ LƯỢNG -->
                    <div class="product-quantity-area">

                        <span>Số lượng:</span>

                        <div class="product-quantity">

                            <button type="button" id="quantityMinus">
                                <i class="fa-solid fa-minus"></i>
                            </button>

                            <input type="number" id="productQuantity" value="1" min="1" readonly>

                            <button type="button" id="quantityPlus">
                                <i class="fa-solid fa-plus"></i>
                            </button>

                        </div>

                    </div>


                    <!-- THÊM VÀO GIỎ -->
                    <form action="index.php?controller=giohang&action=add" method="POST" id="addToCartForm">

                        <input type="hidden" name="MaBienThe" id="selectedVariant" value="<?= htmlspecialchars($bienTheMacDinh['MaBienThe'] ?? '') ?>">

                        <input type="hidden" name="SoLuong" id="selectedQuantity" value="1">

                        <button type="submit" class="product-add-cart" id="addToCartButton" <?= (!$bienTheMacDinh || (int) $bienTheMacDinh['SoLuongTon'] <= 0) ? 'disabled' : '' ?>><i class="fa-solid fa-cart-plus"></i> THÊM VÀO GIỎ</button>

                    </form>

                    <div class="add-cart-message" id="addCartMessage"></div>


                    <!-- MUA NGAY -->
                    <button type="button" class="product-buy-now" id="buyNowButton" <?= (!$bienTheMacDinh || (int) $bienTheMacDinh['SoLuongTon'] <= 0) ? 'disabled' : '' ?>>
                        Mua ngay
                    </button>



                    <!-- DỊCH VỤ -->
                    <div class="product-service-list">

                        <div>
                            <i class="fa-solid fa-truck-fast"></i>
                            Miễn phí vận chuyển
                        </div>

                        <div>
                            <i class="fa-solid fa-rotate-left"></i>
                            Hỗ trợ đổi trả
                        </div>

                        <div>
                            <i class="fa-solid fa-shield-halved"></i>
                            Thanh toán an toàn
                        </div>

                    </div>

                </div>

            </section>


            <!-- THÔNG TIN SẢN PHẨM -->
            <section class="product-description">

                <h2>THÔNG TIN SẢN PHẨM</h2>

                <div class="product-description-content">

                    <p>
                        <strong>Tên sản phẩm:</strong>
                        <?= htmlspecialchars($sanPham['TenSP']) ?>
                    </p>

                    <p>
                        <strong>Loại sản phẩm:</strong>
                        <?= htmlspecialchars($sanPham['TenLoai']) ?>
                    </p>

                    <p>
                        <strong>Nhãn hiệu:</strong>
                        <?= htmlspecialchars($sanPham['TenNhanHieu']) ?>
                    </p>

                    <p>
                        <strong>Chất liệu:</strong>
                        <?= !empty($sanPham['ChatLieu']) ? htmlspecialchars($sanPham['ChatLieu']) : 'Chưa cập nhật' ?>
                    </p>

                    <p>
                        <strong>Giới tính:</strong>
                        <?= !empty($sanPham['GioiTinh']) ? htmlspecialchars($sanPham['GioiTinh']) : 'Chưa cập nhật' ?>
                    </p>

                    <div class="product-description-text">

                        <strong>Mô tả sản phẩm:</strong>

                        <p>
                            <?= !empty($sanPham['MoTa']) ? nl2br(htmlspecialchars($sanPham['MoTa'])) : 'Chưa có mô tả cho sản phẩm này.' ?>
                        </p>

                    </div>

                </div>

            </section>


            <!-- SẢN PHẨM CÙNG LOẠI -->
            <?php if (!empty($sanPhamCungLoai)): ?>

                <section class="related-products">

                    <div class="home-product-heading">
                        <h2>SẢN PHẨM CÙNG LOẠI</h2>
                    </div>

                    <div class="product-slider-wrapper">

                        <button type="button" class="product-slider-button product-slider-prev" data-slider="relatedProductSlider">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <div class="product-slider" id="relatedProductSlider">

                            <?php foreach ($sanPhamCungLoai as $sanPhamLienQuan): ?>

                                <div class="product-card">

                                    <a href="index.php?controller=sanpham&action=detail&id=<?= urlencode($sanPhamLienQuan['MaSP']) ?>" class="product-image">

                                        <?php if (!empty($sanPhamLienQuan['HinhAnh'])): ?>

                                            <img src="public/Uploads/products/<?= htmlspecialchars($sanPhamLienQuan['HinhAnh']) ?>" alt="<?= htmlspecialchars($sanPhamLienQuan['TenSP']) ?>">

                                        <?php else: ?>

                                            <div class="product-no-image">
                                                <i class="fa-regular fa-image"></i>
                                            </div>

                                        <?php endif; ?>

                                    </a>

                                    <div class="product-info">

                                        <h3>
                                            <a href="index.php?controller=sanpham&action=detail&id=<?= urlencode($sanPhamLienQuan['MaSP']) ?>">
                                                <?= htmlspecialchars($sanPhamLienQuan['TenSP']) ?>
                                            </a>
                                        </h3>

                                        <div class="product-price">
                                            <?= number_format((float) $sanPhamLienQuan['GiaBan'], 0, ',', '.') ?>đ
                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                        <button type="button" class="product-slider-button product-slider-next" data-slider="relatedProductSlider">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

                    </div>

                </section>

            <?php endif; ?>

        </main>
        <!-- MODAL YÊU CẦU CẬP NHẬT ĐỊA CHỈ -->
        <div class="address-required-modal" id="addressRequiredModal">

            <div class="address-required-box">

                <div class="address-required-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>

                <h3>Chưa có địa chỉ giao hàng</h3>

                <p>
                    Bạn cần cập nhật địa chỉ và số điện thoại trước khi thêm sản phẩm vào giỏ hàng.
                </p>

                <div class="address-required-actions">



                    <a href="index.php?controller=diachi&action=create" class="address-modal-update">
                        Cập nhật địa chỉ
                    </a>
                    <button type="button" class="address-modal-close" id="addressModalClose">
                        Đóng
                    </button>
                </div>

            </div>

        </div>
        <?php require __DIR__ . '/../home/footer.php'; ?>

    </div>


    <!-- DỮ LIỆU BIẾN THỂ -->
    <script>
        const productVariants = <?= json_encode($bienThes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

        let selectedColor = <?= json_encode($bienTheMacDinh['MaMau'] ?? null) ?>;
        let selectedSize = <?= json_encode($bienTheMacDinh['MaSize'] ?? null) ?>;

        const colorButtons = document.querySelectorAll('.product-color-option');
        const sizeButtons = document.querySelectorAll('.product-size-option');

        const productPrice = document.getElementById('productPrice');
        const productStockInfo = document.getElementById('productStockInfo');
        const productStatus = document.getElementById('productStatus');

        const selectedColorName = document.getElementById('selectedColorName');
        const selectedSizeName = document.getElementById('selectedSizeName');

        const selectedVariant = document.getElementById('selectedVariant');
        const selectedQuantity = document.getElementById('selectedQuantity');

        const productQuantity = document.getElementById('productQuantity');

        const quantityMinus = document.getElementById('quantityMinus');
        const quantityPlus = document.getElementById('quantityPlus');

        const addToCartForm = document.getElementById('addToCartForm');
        const addToCartButton = document.getElementById('addToCartButton');
        const addCartMessage = document.getElementById('addCartMessage');

        const buyNowButton = document.getElementById('buyNowButton');

        const thumbnails = document.querySelectorAll('.product-thumbnail');
        const mainProductImage = document.getElementById('mainProductImage');



        // ĐỔI ẢNH


        thumbnails.forEach(function(thumbnail) {

            thumbnail.addEventListener('click', function() {

                thumbnails.forEach(function(item) {
                    item.classList.remove('active');
                });

                thumbnail.classList.add('active');

                if (mainProductImage) {
                    mainProductImage.src = thumbnail.dataset.image;
                }

            });

        });



        // TÌM BIẾN THỂ


        function findVariant() {

            return productVariants.find(function(variant) {

                return String(variant.MaMau) === String(selectedColor) &&
                    String(variant.MaSize) === String(selectedSize);

            });

        }



        // CẬP NHẬT BIẾN THỂ


        function updateVariant() {

            const variant = findVariant();

            productQuantity.value = 1;
            selectedQuantity.value = 1;

            if (!variant) {

                selectedVariant.value = '';

                productPrice.textContent = 'Không có biến thể';

                productStockInfo.textContent =
                    'Màu sắc và kích thước này hiện không có.';

                productStatus.className = 'out-stock';

                productStatus.innerHTML =
                    '<i class="fa-solid fa-circle-xmark"></i> Không có';

                addToCartButton.disabled = true;
                buyNowButton.disabled = true;

                return;
            }

            selectedVariant.value = variant.MaBienThe;

            const price = Number(variant.GiaBan);

            productPrice.textContent =
                price.toLocaleString('vi-VN') + 'đ';

            const stock = Number(variant.SoLuongTon);

            if (stock > 0) {

                productStockInfo.textContent =
                    'Còn ' + stock + ' sản phẩm';

                productStatus.className = 'in-stock';

                productStatus.innerHTML =
                    '<i class="fa-solid fa-circle-check"></i> Còn hàng';

                addToCartButton.disabled = false;
                buyNowButton.disabled = false;

            } else {

                productStockInfo.textContent = 'Hết hàng';

                productStatus.className = 'out-stock';

                productStatus.innerHTML =
                    '<i class="fa-solid fa-circle-xmark"></i> Hết hàng';

                addToCartButton.disabled = true;
                buyNowButton.disabled = true;

            }

        }



        // CHỌN MÀU


        colorButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                selectedColor = button.dataset.color;

                selectedColorName.textContent =
                    button.dataset.name;

                colorButtons.forEach(function(item) {
                    item.classList.remove('active');
                });

                button.classList.add('active');

                updateVariant();

            });

        });



        // CHỌN SIZE


        sizeButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                selectedSize = button.dataset.size;

                selectedSizeName.textContent =
                    button.textContent.trim();

                sizeButtons.forEach(function(item) {
                    item.classList.remove('active');
                });

                button.classList.add('active');

                updateVariant();

            });

        });



        // GIẢM SỐ LƯỢNG


        quantityMinus.addEventListener('click', function() {

            let quantity = Number(productQuantity.value);

            if (quantity > 1) {
                quantity--;
            }

            productQuantity.value = quantity;
            selectedQuantity.value = quantity;

        });



        // TĂNG SỐ LƯỢNG


        quantityPlus.addEventListener('click', function() {

            const variant = findVariant();

            if (!variant) {
                return;
            }

            let quantity = Number(productQuantity.value);
            const stock = Number(variant.SoLuongTon);

            if (quantity < stock) {
                quantity++;
            }

            productQuantity.value = quantity;
            selectedQuantity.value = quantity;

        });



        // THÊM VÀO GIỎ BẰNG AJAX


        addToCartForm.addEventListener('submit', async function(event) {

            event.preventDefault();

            const variant = findVariant();

            if (!variant || !selectedVariant.value) {

                showCartMessage(
                    'Vui lòng chọn màu sắc và kích thước.',
                    false
                );

                return;
            }

            if (Number(variant.SoLuongTon) <= 0) {

                showCartMessage(
                    'Sản phẩm này hiện đã hết hàng.',
                    false
                );

                return;
            }

            addToCartButton.disabled = true;

            const oldButtonContent =
                addToCartButton.innerHTML;

            addToCartButton.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i> ĐANG THÊM...';

            try {

                const formData =
                    new FormData(addToCartForm);

                const response = await fetch(
                    addToCartForm.action, {
                        method: 'POST',
                        body: formData
                    }
                );

                const data = await response.json();

                if (!data.success) {

                    if (data.loginRequired) {

                        window.location.href =
                            'index.php?controller=taikhoan&action=login';

                        return;
                    }

                    if (data.addressRequired) {

                        const addressModal =
                            document.getElementById('addressRequiredModal');

                        if (addressModal) {
                            addressModal.classList.add('show');
                        }

                        return;
                    }

                    showCartMessage(
                        data.message || 'Không thể thêm vào giỏ hàng.',
                        false
                    );

                    return;
                }



                // THÊM DB THÀNH CÔNG
                // ẢNH BAY VÀO GIỎ

                await flyProductToCart();


                // CẬP NHẬT SỐ GIỎ HÀNG

                updateCartBadge(data.cartCount);


                // THÔNG BÁO

                showCartMessage(
                    data.message || 'Đã thêm sản phẩm vào giỏ hàng.',
                    true
                );

            } catch (error) {

                console.error(error);

                showCartMessage(
                    'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.',
                    false
                );

            } finally {

                addToCartButton.disabled = false;

                addToCartButton.innerHTML =
                    oldButtonContent;

            }

        });
    
        // MODAL YÊU CẦU CẬP NHẬT ĐỊA CHỈ
    

        const addressRequiredModal =
            document.getElementById('addressRequiredModal');

        const addressModalClose =
            document.getElementById('addressModalClose');


        // NÚT ĐÓNG
        if (addressModalClose && addressRequiredModal) {

            addressModalClose.addEventListener('click', function() {

                addressRequiredModal.classList.remove('show');

            });

        }


        // CLICK VÙNG TỐI ĐỂ ĐÓNG
        if (addressRequiredModal) {

            addressRequiredModal.addEventListener('click', function(event) {

                if (event.target === addressRequiredModal) {

                    addressRequiredModal.classList.remove('show');

                }

            });

        }


        // ẢNH BAY VÀO GIỎ


        function flyProductToCart() {

            return new Promise(function(resolve) {

                const productImage =
                    document.getElementById('mainProductImage');

                const cart =
                    document.getElementById('headerCart');

                if (!productImage || !cart) {
                    resolve();
                    return;
                }

                const imageRect =
                    productImage.getBoundingClientRect();

                const cartRect =
                    cart.getBoundingClientRect();


                // Tạo bản sao ảnh

                const flyingImage =
                    productImage.cloneNode(true);

                flyingImage.removeAttribute('id');

                flyingImage.classList.add(
                    'flying-cart-image'
                );


                // Vị trí ban đầu

                flyingImage.style.left =
                    imageRect.left + 'px';

                flyingImage.style.top =
                    imageRect.top + 'px';

                flyingImage.style.width =
                    imageRect.width + 'px';

                flyingImage.style.height =
                    imageRect.height + 'px';


                document.body.appendChild(
                    flyingImage
                );


                // Bắt trình duyệt render vị trí đầu

                flyingImage.getBoundingClientRect();


                // Tâm icon giỏ hàng

                const cartCenterX =
                    cartRect.left +
                    cartRect.width / 2;

                const cartCenterY =
                    cartRect.top +
                    cartRect.height / 2;


                const finalSize = 25;


                requestAnimationFrame(function() {

                    flyingImage.style.left =
                        (cartCenterX - finalSize / 2) +
                        'px';

                    flyingImage.style.top =
                        (cartCenterY - finalSize / 2) +
                        'px';

                    flyingImage.style.width =
                        finalSize + 'px';

                    flyingImage.style.height =
                        finalSize + 'px';

                    flyingImage.style.opacity =
                        '0.25';

                    flyingImage.style.transform =
                        'rotate(15deg)';

                });


                let finished = false;

                function finishAnimation() {

                    if (finished) {
                        return;
                    }

                    finished = true;

                    flyingImage.remove();


                    // RUNG ICON GIỎ

                    cart.classList.remove(
                        'cart-added'
                    );

                    void cart.offsetWidth;

                    cart.classList.add(
                        'cart-added'
                    );


                    setTimeout(function() {

                        cart.classList.remove(
                            'cart-added'
                        );

                    }, 500);


                    resolve();

                }


                flyingImage.addEventListener(
                    'transitionend',
                    finishAnimation, {
                        once: true
                    }
                );


                // Dự phòng nếu transitionend không chạy

                setTimeout(
                    finishAnimation,
                    1400
                );

            });

        }



        // CẬP NHẬT BADGE GIỎ HÀNG


        function updateCartBadge(cartCount) {

            const cart =
                document.getElementById('headerCart');

            if (!cart) {
                return;
            }

            let badge =
                document.getElementById('cartBadge');


            // Chưa có badge -> tạo mới

            if (!badge) {

                badge =
                    document.createElement('span');

                badge.className =
                    'cart-badge';

                badge.id =
                    'cartBadge';

                cart.appendChild(
                    badge
                );

            }


            badge.textContent =
                Number(cartCount) > 99 ?
                '99+' :
                Number(cartCount);


            // Hiệu ứng badge

            badge.classList.remove(
                'badge-added'
            );

            void badge.offsetWidth;

            badge.classList.add(
                'badge-added'
            );


            setTimeout(function() {

                badge.classList.remove(
                    'badge-added'
                );

            }, 500);

        }



        // THÔNG BÁO


        function showCartMessage(message, success) {

            if (!addCartMessage) {
                return;
            }

            addCartMessage.textContent =
                message;

            addCartMessage.className =
                success ?
                'add-cart-message success' :
                'add-cart-message error';

            addCartMessage.classList.add(
                'show'
            );


            setTimeout(function() {

                addCartMessage.classList.remove(
                    'show'
                );

            }, 2500);

        }



        // SLIDER SẢN PHẨM CÙNG LOẠI


        const sliderButtonsNext =
            document.querySelectorAll(
                '.product-slider-next'
            );

        const sliderButtonsPrev =
            document.querySelectorAll(
                '.product-slider-prev'
            );


        sliderButtonsNext.forEach(
            function(button) {

                button.addEventListener(
                    'click',
                    function() {

                        const slider =
                            document.getElementById(
                                button.dataset.slider
                            );

                        if (slider) {

                            slider.scrollBy({
                                left: slider.clientWidth,
                                behavior: 'smooth'
                            });

                        }

                    }
                );

            }
        );


        sliderButtonsPrev.forEach(
            function(button) {

                button.addEventListener(
                    'click',
                    function() {

                        const slider =
                            document.getElementById(
                                button.dataset.slider
                            );

                        if (slider) {

                            slider.scrollBy({
                                left: -slider.clientWidth,
                                behavior: 'smooth'
                            });

                        }

                    }
                );

            }
        );
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>