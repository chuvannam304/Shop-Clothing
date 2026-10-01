<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'NamShop' ?></title>

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/chatbox.css">
</head>

<body>
    <?php require __DIR__ . '/header.php'; ?>
    <div class="container">
        

        <div class="main">
            <!-- carousel -->
            <div id="homeCarousel" class="carousel slide" data-ride="carousel">

                <ol class="carousel-indicators">
                    <li data-target="#homeCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#homeCarousel" data-slide-to="1"></li>
                </ol>

                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <img src="public/images/carousel/carousel1.png"
                            class="d-block w-100"
                            alt="NamShop Carousel 1">
                    </div>

                    <div class="carousel-item">
                        <img src="public/images/carousel/carousel2.png"
                            class="d-block w-100"
                            alt="NamShop Carousel 2">
                    </div>

                </div>

                <a class="carousel-control-prev"
                    href="#homeCarousel"
                    role="button"
                    data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>

                <a class="carousel-control-next"
                    href="#homeCarousel"
                    role="button"
                    data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>

            </div>
            <!-- icon -->
            <div class="container namshop-benefits">

                <div class="row">

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="namshop-benefit-card">

                            <div class="namshop-benefit-icon">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>

                            <h5>Miễn phí vận chuyển</h5>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="namshop-benefit-card">

                            <div class="namshop-benefit-icon">
                                <i class="fa-solid fa-rotate-left"></i>
                            </div>

                            <h5>Đổi trả dễ dàng</h5>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="namshop-benefit-card">

                            <div class="namshop-benefit-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                            <h5>Thanh toán an toàn</h5>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="namshop-benefit-card">

                            <div class="namshop-benefit-icon">
                                <i class="fa-solid fa-headset"></i>
                            </div>

                            <h5>Hỗ trợ khách hàng</h5>

                        </div>
                    </div>

                </div>

            </div>
            <!-- sản phẩm -->
            <!-- SẢN PHẨM ÁO -->
            <section class="home-products">

                <div class="container-fluid">

                    <div class="home-product-heading">
                        <h2>ÁO</h2>

                        <a href="index.php?controller=sanpham&action=all" class="view-all">
                            Xem tất cả <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <?php if (!empty($sanPhamAo)): ?>

                        <div class="product-slider-wrapper">

                            <button type="button" class="product-slider-button product-slider-prev" data-slider="homeAoSlider">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>

                            <div class="product-slider" id="homeAoSlider">

                                <?php foreach ($sanPhamAo as $sanPham): ?>

                                    <div class="product-card">

                                        <a href="index.php?controller=sanpham&action=detail&id=<?= urlencode($sanPham['MaSP']) ?>" class="product-image">

                                            <?php if (!empty($sanPham['HinhAnh'])): ?>

                                                <img src="public/Uploads/products/<?= htmlspecialchars($sanPham['HinhAnh']) ?>" alt="<?= htmlspecialchars($sanPham['TenSP']) ?>">

                                            <?php else: ?>

                                                <div class="product-no-image">
                                                    <i class="fa-regular fa-image"></i>
                                                </div>

                                            <?php endif; ?>

                                        </a>

                                        <div class="product-info">

                                            <h3>
                                                <a href="index.php?controller=sanpham&action=detail&id=<?= urlencode($sanPham['MaSP']) ?>">
                                                    <?= htmlspecialchars($sanPham['TenSP']) ?>
                                                </a>
                                            </h3>

                                            <div class="product-price">
                                                <?= number_format($sanPham['GiaBan'], 0, ',', '.') ?>đ
                                            </div>

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                            <button type="button" class="product-slider-button product-slider-next" data-slider="homeAoSlider">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>

                        </div>

                    <?php else: ?>

                        <div class="no-products">
                            Chưa có sản phẩm áo.
                        </div>

                    <?php endif; ?>

                </div>

            </section>

            <!-- SẢN PHẨM QUẦN -->
            <section class="home-products">

                <div class="container-fluid">

                    <div class="home-product-heading">
                        <h2>QUẦN</h2>

                        <a href="index.php?controller=sanpham&action=index&loai=quan">
                            Xem tất cả
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <?php if (!empty($sanPhamQuan)): ?>

                        <div class="product-slider-wrapper">

                            <button type="button" class="product-slider-button product-slider-prev" data-slider="homeQuanSlider">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>

                            <div class="product-slider" id="homeQuanSlider">

                                <?php foreach ($sanPhamQuan as $sanPham): ?>

                                    <div class="product-card">

                                        <a href="index.php?controller=sanpham&action=detail&id=<?= urlencode($sanPham['MaSP']) ?>" class="product-image">

                                            <?php if (!empty($sanPham['HinhAnh'])): ?>

                                                <img src="public/Uploads/products/<?= htmlspecialchars($sanPham['HinhAnh']) ?>" alt="<?= htmlspecialchars($sanPham['TenSP']) ?>">

                                            <?php else: ?>

                                                <div class="product-no-image">
                                                    <i class="fa-regular fa-image"></i>
                                                </div>

                                            <?php endif; ?>

                                        </a>

                                        <div class="product-info">

                                            <h3>
                                                <a href="index.php?controller=sanpham&action=detail&id=<?= urlencode($sanPham['MaSP']) ?>">
                                                    <?= htmlspecialchars($sanPham['TenSP']) ?>
                                                </a>
                                            </h3>

                                            <div class="product-price">
                                                <?= number_format($sanPham['GiaBan'], 0, ',', '.') ?>đ
                                            </div>

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                            <button type="button" class="product-slider-button product-slider-next" data-slider="homeQuanSlider">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>

                        </div>

                    <?php else: ?>

                        <div class="no-products">
                            Chưa có sản phẩm quần.
                        </div>

                    <?php endif; ?>

                </div>

            </section>
            <!-- chat box -->
            <?php require __DIR__ . '/../layouts/chatbox.php'; ?>
        </div>


    </div>
    <?php require __DIR__ . '/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const nextButtons = document.querySelectorAll('.product-slider-next');
        const prevButtons = document.querySelectorAll('.product-slider-prev');

        nextButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                const sliderId = button.getAttribute('data-slider');
                const slider = document.getElementById(sliderId);

                if (slider) {
                    slider.scrollBy({
                        left: slider.clientWidth,
                        behavior: 'smooth'
                    });
                }

            });

        });

        prevButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                const sliderId = button.getAttribute('data-slider');
                const slider = document.getElementById(sliderId);

                if (slider) {
                    slider.scrollBy({
                        left: -slider.clientWidth,
                        behavior: 'smooth'
                    });
                }

            });

        });
    </script>

</body>

</html>