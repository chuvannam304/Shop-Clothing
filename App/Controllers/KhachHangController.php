<?php

require_once __DIR__ . '/../Models/KhachHang.php';
require_once __DIR__ . '/../Models/HoaDon.php';

class KhachHangController
{
    private $khachHangModel;
    private $hoaDonModel;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->khachHangModel = new KhachHang();
        $this->hoaDonModel = new HoaDon();
    }

    // KIỂM TRA ĐĂNG NHẬP
    private function checkLogin()
    {
        if (!isset($_SESSION['taiKhoan'])) {
            header('Location: index.php?controller=taikhoan&action=login');
            exit;
        }
    }

    // KIỂM TRA ADMIN
    private function checkAdmin()
    {
        $this->checkLogin();

        if (($_SESSION['taiKhoan']['VaiTro'] ?? '') != 2) {
            header('Location: index.php?controller=home&action=index');
            exit;
        }
    }

    // PROFILE KHÁCH HÀNG
    public function profile()
    {
        $this->checkLogin();

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        // Nếu chưa có hồ sơ khách hàng thì tạo
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

    // ĐƠN MUA
    public function orders()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['taiKhoan']['MaTK'])) {
            header('Location: index.php?controller=taikhoan&action=login');
            exit;
        }

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        if (!$khachHang) {
            header('Location: index.php?controller=khachhang&action=profile');
            exit;
        }

        $status = trim($_GET['status'] ?? 'all');
        $keyword = trim($_GET['keyword'] ?? '');

        $donHangs = $this->hoaDonModel->getByMaKH(
            $khachHang['MaKH'],
            $status,
            $keyword
        );

        foreach ($donHangs as &$donHang) {
            $donHang['ChiTiet'] = $this->hoaDonModel->getChiTiet($donHang['MaHD']);
        }

        unset($donHang);

        $title = 'Đơn Mua - NamShop';

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

            require __DIR__ . '/../Views/profile/index.php';
            return;
        }

        $hoTen = trim($_POST['HoTen'] ?? '');
        $ngaySinh = $_POST['NgaySinh'] ?? '';
        $gioiTinh = $_POST['GioiTinh'] ?? '';

        if ($hoTen == '') {
            $error = 'Vui lòng nhập họ tên.';
        } elseif (
            $gioiTinh != '' &&
            !in_array($gioiTinh, ['Nam', 'Nu', 'Khac'])
        ) {
            $error = 'Giới tính không hợp lệ.';
        }

        if (isset($error)) {
            $title = 'Hồ sơ của tôi';

            require __DIR__ . '/../Views/profile/index.php';
            return;
        }

        $anhDaiDien = $khachHang['AnhDaiDien'];

        // XỬ LÝ ẢNH ĐẠI DIỆN
        if (
            isset($_FILES['AnhDaiDien']) &&
            $_FILES['AnhDaiDien']['error'] != UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES['AnhDaiDien']['error'] != UPLOAD_ERR_OK) {

                $error = 'Có lỗi xảy ra khi tải ảnh.';
            } elseif ($_FILES['AnhDaiDien']['size'] > 1024 * 1024) {

                $error = 'Ảnh đại diện không được vượt quá 1MB.';
            } else {

                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);

                $mimeType = finfo_file(
                    $fileInfo,
                    $_FILES['AnhDaiDien']['tmp_name']
                );

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

                    if (
                        move_uploaded_file(
                            $_FILES['AnhDaiDien']['tmp_name'],
                            $uploadDir . $fileName
                        )
                    ) {

                        // Xóa ảnh cũ
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

            require __DIR__ . '/../Views/profile/index.php';
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

        require __DIR__ . '/../Views/profile/index.php';
    }


    // ADMIN - DANH SÁCH KHÁCH HÀNG

    public function index()
    {
        $this->checkAdmin();

        $khachHangs = $this->khachHangModel->getAll();

        $title = 'Quản lý khách hàng';
        $activeMenu = 'khachhang';
        $view = __DIR__ . '/../Views/admin/khachhang/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }


    // ADMIN - XEM CHI TIẾT KHÁCH HÀNG

    public function detail()
    {
        $this->checkAdmin();

        $maKH = $_GET['id'] ?? '';

        if ($maKH == '') {
            header('Location: index.php?controller=khachhang&action=index');
            exit;
        }

        $khachHang = $this->khachHangModel->getById($maKH);

        if (!$khachHang) {
            header('Location: index.php?controller=khachhang&action=index');
            exit;
        }

        $title = 'Chi tiết khách hàng';
        $activeMenu = 'khachhang';
        $view = __DIR__ . '/../Views/admin/khachhang/detail.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }


    // ADMIN - KHÓA / MỞ KHÓA KHÁCH HÀNG

    public function changeStatus()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=khachhang&action=index');
            exit;
        }

        $maTK = $_POST['MaTK'] ?? '';
        $trangThai = isset($_POST['TrangThai'])
            ? (int) $_POST['TrangThai']
            : -1;

        if (
            $maTK == '' ||
            !in_array($trangThai, [0, 1], true)
        ) {
            header('Location: index.php?controller=khachhang&action=index');
            exit;
        }

        $this->khachHangModel->updateTrangThai(
            $maTK,
            $trangThai
        );

        header('Location: index.php?controller=khachhang&action=index');
        exit;
    }
}
