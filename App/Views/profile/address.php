<?php

/** @var array $khachHang */
/** @var array $diaChis */

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Địa chỉ của tôi') ?> - NamShop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/profile.css">
    <link rel="stylesheet" href="public/css/diachi.css">
</head>

<body class="profile-page">

    <div class="container">

        <?php require __DIR__ . '/../home/header.php'; ?>
        <div class="container-fluid profile-wrapper">
            <div class="row">

                <!-- MENU PROFILE -->
                <div class="col-lg-2 col-md-3">
                    <?php require __DIR__ . '/menu.php'; ?>
                </div>

                <!-- NỘI DUNG -->
                <div class="col-lg-10 col-md-9">

                    <div class="address-page">

                        <!-- HEADER -->
                        <div class="address-header">

                            <div>
                                <h2>Địa chỉ của tôi</h2>
                                <p>Quản lý thông tin nhận hàng của bạn</p>
                            </div>

                            <a href="index.php?controller=diachi&action=create" class="btn-add-address"><i class="fa-solid fa-plus"></i> Thêm địa chỉ mới</a>

                        </div>

                        <!-- THÔNG BÁO -->
                        <?php if (isset($_SESSION['address_success'])): ?>

                            <div class="alert alert-success">
                                <?= htmlspecialchars($_SESSION['address_success']) ?>
                            </div>

                            <?php unset($_SESSION['address_success']); ?>

                        <?php endif; ?>

                        <?php if (isset($_SESSION['address_error'])): ?>

                            <div class="alert alert-danger">
                                <?= htmlspecialchars($_SESSION['address_error']) ?>
                            </div>

                            <?php unset($_SESSION['address_error']); ?>

                        <?php endif; ?>


                        <?php if (!empty($diaChis)): ?>

                            <div class="address-list">

                                <?php foreach ($diaChis as $diaChi): ?>

                                    <div class="address-card">

                                        <div class="address-content">

                                            <div class="address-name-phone">

                                                <strong>
                                                    <?= htmlspecialchars($diaChi['HoTenNguoiNhan']) ?>
                                                </strong>

                                                <span></span>

                                                <span>
                                                    <?= htmlspecialchars($diaChi['SoDienThoai']) ?>
                                                </span>

                                            </div>

                                            <div class="address-detail">

                                                <p>
                                                    <?= htmlspecialchars($diaChi['DiaChiChiTiet']) ?>
                                                </p>

                                                <p>
                                                    <?= htmlspecialchars($diaChi['PhuongXa']) ?>,
                                                    <?= htmlspecialchars($diaChi['QuanHuyen']) ?>,
                                                    <?= htmlspecialchars($diaChi['TinhThanh']) ?>
                                                </p>

                                            </div>

                                            <?php if ((int) $diaChi['MacDinh'] === 1): ?>

                                                <div class="default-address-label">
                                                    Mặc định
                                                </div>

                                            <?php endif; ?>

                                        </div>


                                        <!-- THAO TÁC -->
                                        <div class="address-actions">

                                            <a href="index.php?controller=diachi&action=edit&id=<?= urlencode($diaChi['MaDiaChi']) ?>">Cập nhật</a>

                                            <?php if ((int) $diaChi['MacDinh'] !== 1): ?>

                                                <form action="index.php?controller=diachi&action=setDefault" method="POST">
                                                    <input type="hidden" name="MaDiaChi" value="<?= htmlspecialchars($diaChi['MaDiaChi']) ?>">
                                                    <button type="submit" class="btn-set-default">Thiết lập mặc định</button>
                                                </form>

                                                <form action="index.php?controller=diachi&action=delete" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa địa chỉ này?');">
                                                    <input type="hidden" name="MaDiaChi" value="<?= htmlspecialchars($diaChi['MaDiaChi']) ?>">
                                                    <button type="submit" class="btn-delete-address">Xóa</button>
                                                </form>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        <?php else: ?>

                            <!-- CHƯA CÓ ĐỊA CHỈ -->
                            <div class="empty-address">

                                <i class="fa-solid fa-location-dot"></i>

                                <h3>Bạn chưa có địa chỉ</h3>

                                <p>
                                    Thêm địa chỉ để sử dụng khi mua hàng tại NamShop.
                                </p>

                                <a href="index.php?controller=diachi&action=create">Thêm địa chỉ</a>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>
        <?php require __DIR__ . '/../home/footer.php'; ?>

    </div>

</body>

</html>