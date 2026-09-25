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
</head>

<body>

    <?php require __DIR__ . '/header.php'; ?>

    <div class="main">

        <div id="homeCarousel" class="carousel slide" data-ride="carousel">

            <ol class="carousel-indicators">
                <li data-target="#homeCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#homeCarousel" data-slide-to="1"></li>
            </ol>

            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img src="public/images/carousel/carousel1.png" class="d-block w-100" alt="NamShop Carousel 1">
                </div>

                <div class="carousel-item">
                    <img src="public/images/carousel/carousel2.png" class="d-block w-100" alt="NamShop Carousel 2">
                </div>

            </div>

            <a class="carousel-control-prev" href="#homeCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>

            <a class="carousel-control-next" href="#homeCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>

        </div>

        <!-- icons -->
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

    </div>

    <?php require __DIR__ . '/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>