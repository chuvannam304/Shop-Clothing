<?php

require_once __DIR__ . '/../Models/DiaChi.php';
require_once __DIR__ . '/../Models/KhachHang.php';

class DiaChiController
{
    private $diaChiModel;
    private $khachHangModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->diaChiModel = new DiaChi();
        $this->khachHangModel = new KhachHang();
    }

    // KIỂM TRA ĐĂNG NHẬP
    private function checkLogin()
    {
        if (!isset($_SESSION['taiKhoan'])) {
            header('Location: index.php?controller=taikhoan&action=login');
            exit;
        }

    }

    // LẤY KHÁCH HÀNG ĐANG ĐĂNG NHẬP
    private function getCurrentCustomer()
    {
        $this->checkLogin();

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        if (!$khachHang) {
            header('Location: index.php?controller=khachhang&action=profile');
            exit;
        }

        return $khachHang;
    }

    // DANH SÁCH ĐỊA CHỈ
    public function index()
    {
        $khachHang = $this->getCurrentCustomer();

        $diaChis = $this->diaChiModel->getByMaKH(
            $khachHang['MaKH']
        );

        $title = 'Địa chỉ của tôi';

        require __DIR__ . '/../Views/profile/address.php';
    }

    // FORM THÊM ĐỊA CHỈ
    public function create()
    {
        $khachHang = $this->getCurrentCustomer();

        $title = 'Thêm địa chỉ';

        require __DIR__ . '/../Views/profile/address_create.php';
    }

    // LƯU ĐỊA CHỈ
    public function store()
    {
        $khachHang = $this->getCurrentCustomer();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        $hoTenNguoiNhan = trim($_POST['HoTenNguoiNhan'] ?? '');
        $soDienThoai = trim($_POST['SoDienThoai'] ?? '');
        $diaChiChiTiet = trim($_POST['DiaChiChiTiet'] ?? '');
        $phuongXa = trim($_POST['PhuongXa'] ?? '');
        $quanHuyen = trim($_POST['QuanHuyen'] ?? '');
        $tinhThanh = trim($_POST['TinhThanh'] ?? '');

        $macDinh = isset($_POST['MacDinh']) ? 1 : 0;

        if ($hoTenNguoiNhan == '') {
            $error = 'Vui lòng nhập họ tên người nhận.';
        } elseif ($soDienThoai == '') {
            $error = 'Vui lòng nhập số điện thoại.';
        } elseif (!preg_match('/^0[0-9]{9}$/', $soDienThoai)) {
            $error = 'Số điện thoại phải gồm 10 số và bắt đầu bằng 0.';
        } elseif ($tinhThanh == '') {
            $error = 'Vui lòng nhập tỉnh/thành phố.';
        } elseif ($quanHuyen == '') {
            $error = 'Vui lòng nhập quận/huyện.';
        } elseif ($phuongXa == '') {
            $error = 'Vui lòng nhập phường/xã.';
        } elseif ($diaChiChiTiet == '') {
            $error = 'Vui lòng nhập địa chỉ chi tiết.';
        }

        if (isset($error)) {
            $title = 'Thêm địa chỉ';

            require __DIR__ . '/../Views/profile/address-create.php';
            return;
        }

        // Nếu đây là địa chỉ đầu tiên thì tự đặt mặc định
        if (!$this->diaChiModel->hasAddress($khachHang['MaKH'])) {
            $macDinh = 1;
        }

        $this->diaChiModel->create([
            'MaDiaChi' => $this->diaChiModel->generateMaDiaChi(),
            'MaKH' => $khachHang['MaKH'],
            'HoTenNguoiNhan' => $hoTenNguoiNhan,
            'SoDienThoai' => $soDienThoai,
            'DiaChiChiTiet' => $diaChiChiTiet,
            'PhuongXa' => $phuongXa,
            'QuanHuyen' => $quanHuyen,
            'TinhThanh' => $tinhThanh,
            'MacDinh' => $macDinh
        ]);

        $_SESSION['address_success'] = 'Thêm địa chỉ thành công.';

        header('Location: index.php?controller=diachi&action=index');
        exit;
    }

    // FORM SỬA ĐỊA CHỈ
    public function edit()
    {
        $khachHang = $this->getCurrentCustomer();

        $maDiaChi = $_GET['id'] ?? '';

        if ($maDiaChi == '') {
            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        $diaChi = $this->diaChiModel->getById($maDiaChi);

        // Không tồn tại hoặc không phải địa chỉ của khách đang đăng nhập
        if (
            !$diaChi ||
            $diaChi['MaKH'] != $khachHang['MaKH']
        ) {
            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        $title = 'Cập nhật địa chỉ';

        require __DIR__ . '/../Views/profile/address-edit.php';
    }

    // CẬP NHẬT ĐỊA CHỈ
    public function update()
    {
        $khachHang = $this->getCurrentCustomer();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        $maDiaChi = trim($_POST['MaDiaChi'] ?? '');

        $diaChi = $this->diaChiModel->getById($maDiaChi);

        if (
            !$diaChi ||
            $diaChi['MaKH'] != $khachHang['MaKH']
        ) {
            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        $hoTenNguoiNhan = trim($_POST['HoTenNguoiNhan'] ?? '');
        $soDienThoai = trim($_POST['SoDienThoai'] ?? '');
        $diaChiChiTiet = trim($_POST['DiaChiChiTiet'] ?? '');
        $phuongXa = trim($_POST['PhuongXa'] ?? '');
        $quanHuyen = trim($_POST['QuanHuyen'] ?? '');
        $tinhThanh = trim($_POST['TinhThanh'] ?? '');

        $macDinh = isset($_POST['MacDinh']) ? 1 : 0;

        // Không cho bỏ mặc định trực tiếp
        if ((int) $diaChi['MacDinh'] === 1) {
            $macDinh = 1;
        }

        if ($hoTenNguoiNhan == '') {
            $error = 'Vui lòng nhập họ tên người nhận.';
        } elseif ($soDienThoai == '') {
            $error = 'Vui lòng nhập số điện thoại.';
        } elseif (!preg_match('/^0[0-9]{9}$/', $soDienThoai)) {
            $error = 'Số điện thoại phải gồm 10 số và bắt đầu bằng 0.';
        } elseif ($tinhThanh == '') {
            $error = 'Vui lòng nhập tỉnh/thành phố.';
        } elseif ($quanHuyen == '') {
            $error = 'Vui lòng nhập quận/huyện.';
        } elseif ($phuongXa == '') {
            $error = 'Vui lòng nhập phường/xã.';
        } elseif ($diaChiChiTiet == '') {
            $error = 'Vui lòng nhập địa chỉ chi tiết.';
        }

        if (isset($error)) {
            $title = 'Cập nhật địa chỉ';

            require __DIR__ . '/../Views/profile/address-edit.php';
            return;
        }

        $this->diaChiModel->update([
            'MaDiaChi' => $maDiaChi,
            'MaKH' => $khachHang['MaKH'],
            'HoTenNguoiNhan' => $hoTenNguoiNhan,
            'SoDienThoai' => $soDienThoai,
            'DiaChiChiTiet' => $diaChiChiTiet,
            'PhuongXa' => $phuongXa,
            'QuanHuyen' => $quanHuyen,
            'TinhThanh' => $tinhThanh,
            'MacDinh' => $macDinh
        ]);

        $_SESSION['address_success'] = 'Cập nhật địa chỉ thành công.';

        header('Location: index.php?controller=diachi&action=index');
        exit;
    }

    // ĐẶT LÀM ĐỊA CHỈ MẶC ĐỊNH
    public function setDefault()
    {
        $khachHang = $this->getCurrentCustomer();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        $maDiaChi = $_POST['MaDiaChi'] ?? '';

        $diaChi = $this->diaChiModel->getById($maDiaChi);

        if (
            !$diaChi ||
            $diaChi['MaKH'] != $khachHang['MaKH']
        ) {
            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        $this->diaChiModel->setDefault(
            $khachHang['MaKH'],
            $maDiaChi
        );

        $_SESSION['address_success'] = 'Đã đặt làm địa chỉ mặc định.';

        header('Location: index.php?controller=diachi&action=index');
        exit;
    }

    // XÓA ĐỊA CHỈ
    public function delete()
    {
        $khachHang = $this->getCurrentCustomer();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        $maDiaChi = $_POST['MaDiaChi'] ?? '';

        $diaChi = $this->diaChiModel->getById($maDiaChi);

        if (
            !$diaChi ||
            $diaChi['MaKH'] != $khachHang['MaKH']
        ) {
            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        // Không xóa địa chỉ mặc định
        if ((int) $diaChi['MacDinh'] === 1) {
            $_SESSION['address_error'] = 'Không thể xóa địa chỉ mặc định. Hãy chọn địa chỉ mặc định khác trước.';

            header('Location: index.php?controller=diachi&action=index');
            exit;
        }

        $this->diaChiModel->delete(
            $maDiaChi,
            $khachHang['MaKH']
        );

        $_SESSION['address_success'] = 'Xóa địa chỉ thành công.';

        header('Location: index.php?controller=diachi&action=index');
        exit;
    }
}