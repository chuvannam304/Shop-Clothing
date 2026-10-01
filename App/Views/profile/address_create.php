<?php

/** @var array $khachHang */

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Thêm địa chỉ') ?> - NamShop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/profile.css">
    <link rel="stylesheet" href="public/css/diachi.css">
</head>

<body class="profile-page">

    <div class="container">

        <?php require __DIR__ . '/../home/header.php'; ?>

        <div class="container profile-wrapper">

            <div class="row">

                <!-- MENU PROFILE -->
                <div class="col-lg-2 col-md-3">
                    <?php require __DIR__ . '/menu.php'; ?>
                </div>

                <!-- NỘI DUNG -->
                <div class="col-lg-10 col-md-9">

                    <div class="address-form-page">

                        <div class="address-form-header">

                            <h2>Thêm địa chỉ mới</h2>

                            <p>
                                Nhập thông tin địa chỉ nhận hàng.
                            </p>

                        </div>

                        <?php if (isset($error)): ?>

                            <div class="alert alert-danger">
                                <?= htmlspecialchars($error) ?>
                            </div>

                        <?php endif; ?>


                        <form action="index.php?controller=diachi&action=store" method="POST">

                            <!-- HỌ TÊN -->
                            <div class="form-group">

                                <label for="HoTenNguoiNhan">
                                    Họ tên người nhận
                                    <span class="required">*</span>
                                </label>

                                <input type="text" id="HoTenNguoiNhan" name="HoTenNguoiNhan" class="form-control" value="<?= htmlspecialchars($_POST['HoTenNguoiNhan'] ?? ($khachHang['HoTen'] ?? '')) ?>" placeholder="Nhập họ tên người nhận">

                            </div>


                            <!-- SỐ ĐIỆN THOẠI -->
                            <div class="form-group">

                                <label for="SoDienThoai">
                                    Số điện thoại
                                    <span class="required">*</span>
                                </label>

                                <input type="text" id="SoDienThoai" name="SoDienThoai" class="form-control" value="<?= htmlspecialchars($_POST['SoDienThoai'] ?? ($khachHang['SoDienThoai'] ?? '')) ?>" maxlength="10" placeholder="Nhập số điện thoại">

                            </div>


                            <!-- TỈNH THÀNH -->
                            <div class="form-group">

                                <label for="TinhThanh">
                                    Tỉnh / Thành phố
                                    <span class="required">*</span>
                                </label>

                                <input type="text" id="TinhThanh" name="TinhThanh" class="form-control" value="<?= htmlspecialchars($_POST['TinhThanh'] ?? '') ?>" placeholder="Ví dụ: TP. Hồ Chí Minh">

                            </div>


                            <!-- QUẬN HUYỆN -->
                            <div class="form-group">

                                <label for="QuanHuyen">
                                    Quận / Huyện
                                    <span class="required">*</span>
                                </label>

                                <input type="text" id="QuanHuyen" name="QuanHuyen" class="form-control" value="<?= htmlspecialchars($_POST['QuanHuyen'] ?? '') ?>" placeholder="Nhập quận / huyện">

                            </div>


                            <!-- PHƯỜNG XÃ -->
                            <div class="form-group">

                                <label for="PhuongXa">
                                    Phường / Xã
                                    <span class="required">*</span>
                                </label>

                                <input type="text" id="PhuongXa" name="PhuongXa" class="form-control" value="<?= htmlspecialchars($_POST['PhuongXa'] ?? '') ?>" placeholder="Nhập phường / xã">

                            </div>


                            <!-- ĐỊA CHỈ CHI TIẾT -->
                            <div class="form-group">

                                <label for="DiaChiChiTiet">
                                    Địa chỉ chi tiết
                                    <span class="required">*</span>
                                </label>

                                <textarea id="DiaChiChiTiet" name="DiaChiChiTiet" class="form-control" rows="3" placeholder="Số nhà, tên đường..."><?= htmlspecialchars($_POST['DiaChiChiTiet'] ?? '') ?></textarea>

                            </div>


                            <!-- MẶC ĐỊNH -->
                            <div class="address-default-option">

                                <label>
                                    <input type="checkbox" name="MacDinh" value="1" <?= isset($_POST['MacDinh']) ? 'checked' : '' ?>>
                                    Đặt làm địa chỉ mặc định
                                </label>

                            </div>


                            <!-- BUTTON -->
                            <div class="address-form-actions">

                                <a href="index.php?controller=diachi&action=index" class="btn-address-cancel">Hủy</a>

                                <button type="submit" class="btn-address-save">
                                    Lưu địa chỉ
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        <?php require __DIR__ . '/../home/footer.php'; ?>

    </div>

</body>

</html>