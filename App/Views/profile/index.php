<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Hồ sơ của tôi' ?> - NamShop</title>

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="public/css/home.css">
</head>

<body class="profile-page">

    <div class="container-fluid profile-wrapper">

        <div class="row">

            <div class="col-lg-2 col-md-3">

                <?php require __DIR__ . '/menu.php'; ?>

            </div>

            <div class="col-lg-10 col-md-9">

                <div class="profile-card">

                    <div class="profile-header">

                        <h1>Hồ Sơ Của Tôi</h1>

                        <p>
                            Quản lý thông tin hồ sơ để bảo mật tài khoản
                        </p>

                    </div>

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

                    <form
                        action="index.php?controller=khachhang&action=updateProfile"
                        method="POST"
                        enctype="multipart/form-data">

                        <div class="row profile-content">

                            <div class="col-lg-8 col-md-7 profile-form">

                                <div class="form-group row profile-form-group">

                                    <label
                                        for="HoTen"
                                        class="col-lg-3 col-md-4 col-form-label profile-label">

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

                                <div class="form-group row profile-form-group">

                                    <label
                                        class="col-lg-3 col-md-4 col-form-label profile-label">

                                        Email

                                    </label>

                                    <div class="col-lg-9 col-md-8">

                                        <div class="profile-info">

                                            <?= htmlspecialchars($khachHang['Email'] ?? '') ?>

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group row profile-form-group">

                                    <label
                                        class="col-lg-3 col-md-4 col-form-label profile-label">

                                        Số điện thoại

                                    </label>

                                    <div class="col-lg-9 col-md-8">

                                        <div class="profile-info">

                                            <?= htmlspecialchars($khachHang['SoDienThoai'] ?? '') ?>

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group row profile-form-group">

                                    <label
                                        class="col-lg-3 col-md-4 col-form-label profile-label">

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

                                <div class="form-group row profile-form-group">

                                    <label
                                        for="NgaySinh"
                                        class="col-lg-3 col-md-4 col-form-label profile-label">

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

                                <div class="form-group row profile-form-group">

                                    <div class="col-lg-3 col-md-4"></div>

                                    <div class="col-lg-9 col-md-8">

                                        <button
                                            type="submit"
                                            class="profile-save">

                                            Lưu

                                        </button>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-4 col-md-5 profile-avatar">

                                <div class="profile-avatar-image">

                                    <?php if (!empty($khachHang['AnhDaiDien'])): ?>

                                        <img
                                            id="avatarPreview"
                                            src="public/uploads/avatars/<?= htmlspecialchars($khachHang['AnhDaiDien']) ?>"
                                            alt="Ảnh đại diện">

                                    <?php else: ?>

                                        <div
                                            class="profile-avatar-default"
                                            id="avatarDefault">

                                            <i class="fa-regular fa-user"></i>

                                        </div>

                                        <img
                                            id="avatarPreview"
                                            src=""
                                            alt="Ảnh đại diện"
                                            style="display: none;">

                                    <?php endif; ?>

                                </div>

                                <label
                                    for="AnhDaiDien"
                                    class="profile-upload">

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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const avatarInput = document.getElementById('AnhDaiDien');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarDefault = document.getElementById('avatarDefault');

        avatarInput.addEventListener('change', function() {

            const file = this.files[0];

            if (!file) {
                return;
            }

            if (file.size > 1024 * 1024) {
                alert('Dung lượng ảnh không được vượt quá 1 MB.');
                this.value = '';
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