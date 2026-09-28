<?php

require_once __DIR__ . '/../Models/TaiKhoan.php';
require_once __DIR__ . '/../Models/KhachHang.php';

class TaiKhoanController
{
    private $taiKhoanModel;
    private $khachHangModel;

    public function __construct()
    {
        $this->taiKhoanModel = new TaiKhoan();
        $this->khachHangModel = new KhachHang();
    }

    // FORM ĐĂNG KÝ
    public function register()
    {
        $title = 'Đăng ký';

        require __DIR__ . '/../Views/account/register.php';
    }

    // XỬ LÝ ĐĂNG KÝ
    public function storeRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $email = trim($_POST['Email'] ?? '');
        $soDienThoai = trim($_POST['SoDienThoai'] ?? '');
        $matKhau = $_POST['MatKhau'] ?? '';
        $nhapLaiMatKhau = $_POST['NhapLaiMatKhau'] ?? '';

        if ($email == '') {
            $error = 'Email không được để trống.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email không hợp lệ.';
        } elseif ($soDienThoai == '') {
            $error = 'Số điện thoại không được để trống.';
        } elseif (!preg_match('/^0[0-9]{9}$/', $soDienThoai)) {
            $error = 'Số điện thoại phải gồm 10 số và bắt đầu bằng 0.';
        } elseif ($matKhau == '') {
            $error = 'Mật khẩu không được để trống.';
        } elseif (strlen($matKhau) < 6) {
            $error = 'Mật khẩu phải có ít nhất 6 ký tự.';
        } elseif ($matKhau != $nhapLaiMatKhau) {
            $error = 'Nhập lại mật khẩu không khớp.';
        } elseif ($this->taiKhoanModel->getByEmail($email)) {
            $error = 'Email đã được sử dụng.';
        } elseif ($this->taiKhoanModel->getBySoDienThoai($soDienThoai)) {
            $error = 'Số điện thoại đã được sử dụng.';
        }

        if (isset($error)) {
            $title = 'Đăng ký';

            require __DIR__ . '/../Views/account/register.php';
            return;
        }

        $data = [
            'MaTK' => $this->taiKhoanModel->generateMaTK(),
            'Email' => $email,
            'SoDienThoai' => $soDienThoai,
            'MatKhau' => password_hash($matKhau, PASSWORD_DEFAULT),
            'LoaiDangNhap' => 'Local',
            'VaiTro' => 0,
            'TrangThai' => 1
        ];

        $this->taiKhoanModel->create($data);

        $success = 'Đăng ký tài khoản thành công.';
        $title = 'Đăng ký';

        require __DIR__ . '/../Views/account/register.php';
    }

    // FORM ĐĂNG NHẬP
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $title = 'Đăng nhập';

        require __DIR__ . '/../Views/account/login.php';
    }

    // XỬ LÝ ĐĂNG NHẬP
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $login = trim($_POST['Login'] ?? '');
        $matKhau = $_POST['MatKhau'] ?? '';

        if ($login == '') {
            $error = 'Vui lòng nhập email hoặc số điện thoại.';
        } elseif ($matKhau == '') {
            $error = 'Vui lòng nhập mật khẩu.';
        } else {

            $taiKhoan = $this->taiKhoanModel->getByLogin($login);

            if (!$taiKhoan) {
                $error = 'Tài khoản không tồn tại.';
            } elseif ($taiKhoan['TrangThai'] != 1) {
                $error = 'Tài khoản đã bị khóa.';
            } elseif (!password_verify($matKhau, $taiKhoan['MatKhau'])) {
                $error = 'Mật khẩu không chính xác.';
            }
        }

        if (isset($error)) {
            $title = 'Đăng nhập';

            require __DIR__ . '/../Views/account/login.php';
            return;
        }

        $hoTen = strstr($taiKhoan['Email'], '@', true);
        $anhDaiDien = null;

        if ($taiKhoan['VaiTro'] == 0) {

            $khachHang = $this->khachHangModel->getByMaTK(
                $taiKhoan['MaTK']
            );

            if ($khachHang) {

                if (!empty($khachHang['HoTen'])) {
                    $hoTen = $khachHang['HoTen'];
                }

                if (!empty($khachHang['AnhDaiDien'])) {
                    $anhDaiDien = $khachHang['AnhDaiDien'];
                }
            }
        }

        $_SESSION['taiKhoan'] = [
            'MaTK' => $taiKhoan['MaTK'],
            'Email' => $taiKhoan['Email'],
            'SoDienThoai' => $taiKhoan['SoDienThoai'],
            'VaiTro' => $taiKhoan['VaiTro'],
            'HoTen' => $hoTen,
            'AnhDaiDien' => $anhDaiDien
        ];

        // ADMIN
        if ($taiKhoan['VaiTro'] == 2) {

            header(
                'Location: index.php?controller=admin&action=dashboard'
            );
            exit;
        }

        // KHÁCH HÀNG / NHÂN VIÊN
        header(
            'Location: index.php?controller=home&action=index'
        );
        exit;
    }

    // ĐĂNG XUẤT
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header(
            'Location: index.php?controller=home&action=index'
        );
        exit;
    }
    // KIỂM TRA ADMIN
    private function checkAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['taiKhoan'])) {
            header('Location: index.php?controller=taikhoan&action=login');
            exit;
        }

        if ((int) ($_SESSION['taiKhoan']['VaiTro'] ?? 0) !== 2) {
            header('Location: index.php?controller=home&action=index');
            exit;
        }
    }


    // ADMIN - DANH SÁCH TÀI KHOẢN
    public function index()
    {
        $this->checkAdmin();

        $taiKhoans = $this->taiKhoanModel->getAll();

        $title = 'Quản lý tài khoản';
        $activeMenu = 'taikhoan';

        $view = __DIR__ . '/../Views/admin/taikhoan/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }


    // ADMIN - CHI TIẾT TÀI KHOẢN
    public function detail()
    {
        $this->checkAdmin();

        $maTK = $_GET['id'] ?? '';

        if ($maTK == '') {
            header('Location: index.php?controller=taikhoan&action=index');
            exit;
        }

        $taiKhoan = $this->taiKhoanModel->getById($maTK);

        if (!$taiKhoan) {
            header('Location: index.php?controller=taikhoan&action=index');
            exit;
        }

        $title = 'Chi tiết tài khoản';
        $activeMenu = 'taikhoan';

        $view = __DIR__ . '/../Views/admin/taikhoan/detail.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }


    // ADMIN - KHÓA / MỞ KHÓA TÀI KHOẢN
    public function changeStatus()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=taikhoan&action=index');
            exit;
        }

        $maTK = $_POST['MaTK'] ?? '';
        $trangThai = isset($_POST['TrangThai'])
            ? (int) $_POST['TrangThai']
            : -1;

        if ($maTK == '' || !in_array($trangThai, [0, 1], true)) {
            header('Location: index.php?controller=taikhoan&action=index');
            exit;
        }

        // Không cho Admin tự khóa chính mình
        if ($maTK == ($_SESSION['taiKhoan']['MaTK'] ?? '')) {
            header('Location: index.php?controller=taikhoan&action=index');
            exit;
        }

        $this->taiKhoanModel->updateTrangThai($maTK, $trangThai);

        header('Location: index.php?controller=taikhoan&action=index');
        exit;
    }


    // ADMIN - THAY ĐỔI VAI TRÒ
    public function changeRole()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=taikhoan&action=index');
            exit;
        }

        $maTK = $_POST['MaTK'] ?? '';
        $vaiTro = isset($_POST['VaiTro'])
            ? (int) $_POST['VaiTro']
            : -1;

        // Chỉ cho phép Khách hàng hoặc Nhân viên
        if ($maTK == '' || !in_array($vaiTro, [0, 1], true)) {
            header('Location: index.php?controller=taikhoan&action=index');
            exit;
        }

        // Không được thay đổi quyền của chính Admin đang đăng nhập
        if ($maTK == ($_SESSION['taiKhoan']['MaTK'] ?? '')) {
            header('Location: index.php?controller=taikhoan&action=index');
            exit;
        }

        $taiKhoan = $this->taiKhoanModel->getById($maTK);

        // Không cho thay đổi tài khoản Admin khác
        if (!$taiKhoan || (int) $taiKhoan['VaiTro'] === 2) {
            header('Location: index.php?controller=taikhoan&action=index');
            exit;
        }

        $this->taiKhoanModel->updateVaiTro($maTK, $vaiTro);

        header('Location: index.php?controller=taikhoan&action=index');
        exit;
    }
}
