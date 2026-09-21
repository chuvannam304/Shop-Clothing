<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Hồ sơ của tôi' ?> - NamShop</title>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="public/css/home.css">
</head>

<body class="profile-page">

    <div class="container-fluid profile-wrapper">

        <div class="row">

            <!-- =========================
                 MENU BÊN TRÁI
            ========================== -->
            <div class="col-lg-2 col-md-3 profile-sidebar">

                <!-- USER -->
                <div class="profile-sidebar-user">

                    <div class="profile-sidebar-avatar">

                        <?php if (!empty($khachHang['AnhDaiDien'])): ?>

                            <img src="public/uploads/avatars/<?= htmlspecialchars($khachHang['AnhDaiDien']) ?>" alt="Ảnh đại diện">

                        <?php else: ?>

                            <i class="fa-regular fa-user"></i>

                        <?php endif; ?>

                    </div>

                    <div class="profile-sidebar-user-info">
                        <strong><?= htmlspecialchars($khachHang['HoTen'] ?? '') ?></strong>

                        <a href="index.php?controller=khachhang&action=profile">
                            <i class="fa-solid fa-pen"></i> Sửa hồ sơ
                        </a>
                    </div>

                </div>


                <!-- MENU -->
                <div class="profile-sidebar-menu">

                    <div class="profile-menu-title">
                        <i class="fa-regular fa-user"></i>
                        <span>Tài Khoản Của Tôi</span>
                    </div>

                    <div class="profile-submenu">

                        <a href="index.php?controller=khachhang&action=profile" class="active">
                            Hồ Sơ
                        </a>

                        <a href="#">
                            Đổi Mật Khẩu
                        </a>

                    </div>


                    <a href="#" class="profile-menu-item">
                        <i class="fa-regular fa-bell"></i>
                        <span>Thông Báo</span>
                    </a>


                    <a href="index.php?controller=home&action=index" class="profile-menu-item">
                        <i class="fa-solid fa-house"></i>
                        <span>Trang Chủ</span>
                    </a>


                    <a href="index.php?controller=taikhoan&action=logout" class="profile-menu-item">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Đăng Xuất</span>
                    </a>

                </div>

            </div>


            <!-- =========================
                 NỘI DUNG PROFILE
            ========================== -->
            <div class="col-lg-10 col-md-9">

                <div class="profile-card">

                    <!-- HEADER -->
                    <div class="profile-header">
                        <h1>Hồ Sơ Của Tôi</h1>
                        <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
                    </div>


                    <!-- THÔNG BÁO -->
                    <?php if (isset($error)): ?>
                        <div class="account-message account-message-error">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="account-message account-message-success">
                            <?= htmlspecialchars($success) ?>
                        </div>
                    <?php endif; ?>


                    <!-- FORM -->
                    <form action="index.php?controller=khachhang&action=updateProfile"
                          method="POST"
                          enctype="multipart/form-data">

                        <div class="row profile-content">


                            <!-- =========================
                                 THÔNG TIN
                            ========================== -->
                            <div class="col-lg-8 col-md-7 profile-form">

                                <!-- HỌ TÊN -->
                                <div class="form-group row profile-form-group">

                                    <label for="HoTen" class="col-lg-3 col-md-4 col-form-label profile-label">
                                        Họ tên
                                    </label>

                                    <div class="col-lg-9 col-md-8">

                                        <input
                                            type="text"
                                            class="form-control profile-input"
                                            id="HoTen"
                                            name="HoTen"
                                            value="<?= htmlspecialchars($khachHang['HoTen'] ?? '') ?>"
                                            placeholder="Nhập họ tên">

                                    </div>

                                </div>


                                <!-- EMAIL -->
                                <div class="form-group row profile-form-group">

                                    <label class="col-lg-3 col-md-4 col-form-label profile-label">
                                        Email
                                    </label>

                                    <div class="col-lg-9 col-md-8">

                                        <div class="profile-info">
                                            <?= htmlspecialchars($khachHang['Email'] ?? '') ?>
                                        </div>

                                    </div>

                                </div>


                                <!-- SỐ ĐIỆN THOẠI -->
                                <div class="form-group row profile-form-group">

                                    <label class="col-lg-3 col-md-4 col-form-label profile-label">
                                        Số điện thoại
                                    </label>

                                    <div class="col-lg-9 col-md-8">

                                        <div class="profile-info">
                                            <?= htmlspecialchars($khachHang['SoDienThoai'] ?? '') ?>
                                        </div>

                                    </div>

                                </div>


                                <!-- GIỚI TÍNH -->
                                <div class="form-group row profile-form-group">

                                    <label class="col-lg-3 col-md-4 col-form-label profile-label">
                                        Giới tính
                                    </label>

                                    <div class="col-lg-9 col-md-8">

                                        <div class="profile-gender">

                                            <label>
                                                <input
                                                    type="radio"
                                                    name="GioiTinh"
                                                    value="Nam"
                                                    <?= ($khachHang['GioiTinh'] ?? '') == 'Nam' ? 'checked' : '' ?>>

                                                <span>Nam</span>
                                            </label>


                                            <label>
                                                <input
                                                    type="radio"
                                                    name="GioiTinh"
                                                    value="Nu"
                                                    <?= ($khachHang['GioiTinh'] ?? '') == 'Nu' ? 'checked' : '' ?>>

                                                <span>Nữ</span>
                                            </label>


                                            <label>
                                                <input
                                                    type="radio"
                                                    name="GioiTinh"
                                                    value="Khac"
                                                    <?= ($khachHang['GioiTinh'] ?? '') == 'Khac' ? 'checked' : '' ?>>

                                                <span>Khác</span>
                                            </label>

                                        </div>

                                    </div>

                                </div>


                                <!-- NGÀY SINH -->
                                <div class="form-group row profile-form-group">

                                    <label for="NgaySinh" class="col-lg-3 col-md-4 col-form-label profile-label">
                                        Ngày sinh
                                    </label>

                                    <div class="col-lg-9 col-md-8">

                                        <input
                                            type="date"
                                            class="form-control profile-input"
                                            id="NgaySinh"
                                            name="NgaySinh"
                                            value="<?= htmlspecialchars($khachHang['NgaySinh'] ?? '') ?>">

                                    </div>

                                </div>


                                <!-- NÚT LƯU -->
                                <div class="form-group row profile-form-group">

                                    <div class="col-lg-3 col-md-4"></div>

                                    <div class="col-lg-9 col-md-8">

                                        <button type="submit" class="profile-save">
                                            Lưu
                                        </button>

                                    </div>

                                </div>

                            </div>


                            <!-- =========================
                                 AVATAR
                            ========================== -->
                            <div class="col-lg-4 col-md-5 profile-avatar">

                                <div class="profile-avatar-image">

                                    <?php if (!empty($khachHang['AnhDaiDien'])): ?>

                                        <img
                                            id="avatarPreview"
                                            src="public/uploads/avatars/<?= htmlspecialchars($khachHang['AnhDaiDien']) ?>"
                                            alt="Ảnh đại diện">

                                    <?php else: ?>

                                        <div class="profile-avatar-default" id="avatarDefault">
                                            <i class="fa-regular fa-user"></i>
                                        </div>

                                        <img
                                            id="avatarPreview"
                                            src=""
                                            alt="Ảnh đại diện"
                                            style="display: none;">

                                    <?php endif; ?>

                                </div>


                                <label for="AnhDaiDien" class="profile-upload">
                                    Chọn Ảnh
                                </label>

                                <input
                                    type="file"
                                    id="AnhDaiDien"
                                    name="AnhDaiDien"
                                    accept=".jpg,.jpeg,.png"
                                    hidden>


                                <div class="profile-avatar-note">
                                    <p>Dung lượng file tối đa 1 MB</p>
                                    <p>Định dạng: JPEG, PNG</p>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
    <!-- Bootstrap 4 -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- XEM TRƯỚC AVATAR -->
    <script>
        const avatarInput = document.getElementById('AnhDaiDien');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarDefault = document.getElementById('avatarDefault');

        avatarInput.addEventListener('change', function() {

            const file = this.files[0];

            if (!file) {
                return;
            }
            const reader = new FileReader();

            reader.onload = function(e) {

                avatarPreview.src = e.target.result;
                avatarPreview.style.display = 'block';

                if (avatarDefault) {
                    avatarDefault.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>