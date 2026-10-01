<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Đăng ký' ?> - NamShop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/home.css">
</head>

<body>



    <?php require __DIR__ . '/../home/header.php'; ?>
    <div class="container">
        <main class="account-page">
            <div class="account-container">
                <div class="account-box">
                    <h1>Đăng ký</h1>
                    <?php if (isset($error)): ?>
                        <div class="account-message account-message-error"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <div class="account-message account-message-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>
                    <form action="index.php?controller=taikhoan&action=storeRegister" method="POST">
                        <div class="account-form-group">
                            <label for="Email">Email</label>
                            <input type="email" id="Email" name="Email" placeholder="Nhập email" value="<?= isset($error) ? htmlspecialchars($email ?? '') : '' ?>" required>
                        </div>
                        <div class="account-form-group">
                            <label for="SoDienThoai">Số điện thoại</label>
                            <input type="text" id="SoDienThoai" name="SoDienThoai" placeholder="Nhập số điện thoại" maxlength="10" value="<?= isset($error) ? htmlspecialchars($soDienThoai ?? '') : '' ?>" required>
                        </div>
                        <div class="account-form-group">
                            <label for="MatKhau">Mật khẩu</label>
                            <div class="password-box">
                                <input type="password" id="MatKhau" name="MatKhau" placeholder="Nhập mật khẩu" required>
                                <i class="fa-regular fa-eye password-toggle"></i>
                            </div>
                        </div>

                        <div class="account-form-group">
                            <label for="NhapLaiMatKhau">Nhập lại mật khẩu</label>
                            <div class="password-box">
                                <input type="password" id="NhapLaiMatKhau" name="NhapLaiMatKhau" placeholder="Nhập lại mật khẩu" required>
                                <i class="fa-regular fa-eye password-toggle"></i>
                            </div>
                        </div>

                        <button type="submit" class="account-submit">Đăng ký</button>

                    </form>

                    <div class="social-login">
                        <a href="#" class="social-icon" title="Google"><i class="fa-brands fa-google"></i></a>
                        <a href="#" class="social-icon" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-icon" title="Apple"><i class="fa-brands fa-apple"></i></a>
                    </div>
                    <div class="account-switch">
                        <a href="index.php?controller=taikhoan&action=login">Đăng nhập</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php require __DIR__ . '/../home/footer.php'; ?>

</body>

</html>