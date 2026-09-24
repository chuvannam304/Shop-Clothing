<?php

require_once __DIR__ . '/../Models/KhachHang.php';

class KhachHangController
{
    private $khachHangModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->khachHangModel = new KhachHang();
    }

    // Kiểm tra đăng nhập
    private function checkLogin()
    {
        if (!isset($_SESSION['taiKhoan'])) {
            header('Location: index.php?controller=taikhoan&action=login');
            exit;
        }
    }

    // HIỂN THỊ PROFILE
    public function profile()
    {
        $this->checkLogin();

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        // Nếu chưa có hồ sơ khách hàng thì tạo mới
        if (!$this->khachHangModel->existsByMaTK($maTK)) {

            $email = $_SESSION['taiKhoan']['Email'];

            $hoTen = explode('@', $email)[0];

            $this->khachHangModel->create([
                'MaKH' => $this->khachHangModel->generateMaKH(),
                'MaTK' => $maTK,
                'HoTen' => $hoTen,
                'NgaySinh' => null,
                'GioiTinh' => null,
                'AnhDaiDien' => null
            ]);
        }

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        $title = 'Hồ sơ của tôi';

        require __DIR__ . '/../Views/profile/index.php';
    }
    public function orders()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['taiKhoan'])) {
            header('Location: index.php?controller=taikhoan&action=login');
            exit;
        }

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        $title = 'Đơn Mua';

        require __DIR__ . '/../Views/profile/orders.php';
    }
    // CẬP NHẬT PROFILE
    public function updateProfile()
    {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=khachhang&action=profile');
            exit;
        }

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        if (!$khachHang) {
            $error = 'Không tìm thấy hồ sơ khách hàng.';
            $title = 'Hồ sơ của tôi';

            require __DIR__ . '/../Views/account/profile.php';
            return;
        }

        $hoTen = trim($_POST['HoTen'] ?? '');
        $ngaySinh = $_POST['NgaySinh'] ?? '';
        $gioiTinh = $_POST['GioiTinh'] ?? '';

        if ($hoTen == '') {
            $error = 'Vui lòng nhập họ tên.';
        } elseif ($gioiTinh != '' && !in_array($gioiTinh, ['Nam', 'Nu', 'Khac'])) {
            $error = 'Giới tính không hợp lệ.';
        }

        if (isset($error)) {
            $title = 'Hồ sơ của tôi';

            require __DIR__ . '/../Views/account/profile.php';
            return;
        }

        $anhDaiDien = $khachHang['AnhDaiDien'];

        // XỬ LÝ ẢNH ĐẠI DIỆN
        if (isset($_FILES['AnhDaiDien']) && $_FILES['AnhDaiDien']['error'] != UPLOAD_ERR_NO_FILE) {

            if ($_FILES['AnhDaiDien']['error'] != UPLOAD_ERR_OK) {
                $error = 'Có lỗi xảy ra khi tải ảnh.';
            } elseif ($_FILES['AnhDaiDien']['size'] > 1024 * 1024) {
                $error = 'Ảnh đại diện không được vượt quá 1MB.';
            } else {
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($fileInfo, $_FILES['AnhDaiDien']['tmp_name']);
                finfo_close($fileInfo);

                $allowedTypes = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png'
                ];

                if (!isset($allowedTypes[$mimeType])) {
                    $error = 'Ảnh đại diện chỉ hỗ trợ JPEG hoặc PNG.';
                } else {
                    $uploadDir = __DIR__ . '/../../public/uploads/avatars/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $extension = $allowedTypes[$mimeType];

                    $fileName = $maTK . '_' . time() . '.' . $extension;

                    if (move_uploaded_file(
                        $_FILES['AnhDaiDien']['tmp_name'],
                        $uploadDir . $fileName
                    )) {
                        // Xóa ảnh cũ nếu có
                        if (!empty($anhDaiDien)) {
                            $oldImage = $uploadDir . $anhDaiDien;

                            if (file_exists($oldImage)) {
                                unlink($oldImage);
                            }
                        }

                        $anhDaiDien = $fileName;
                    } else {
                        $error = 'Không thể lưu ảnh đại diện.';
                    }
                }
            }
        }

        if (isset($error)) {
            $khachHang = $this->khachHangModel->getByMaTK($maTK);
            $title = 'Hồ sơ của tôi';

            require __DIR__ . '/../Views/account/profile.php';
            return;
        }

        $data = [
            'HoTen' => $hoTen,
            'NgaySinh' => $ngaySinh != '' ? $ngaySinh : null,
            'GioiTinh' => $gioiTinh != '' ? $gioiTinh : null,
            'AnhDaiDien' => $anhDaiDien
        ];

        $this->khachHangModel->update($maTK, $data);

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        $success = 'Cập nhật hồ sơ thành công.';
        $title = 'Hồ sơ của tôi';

        require __DIR__ . '/../Views/account/profile.php';
    }
}
