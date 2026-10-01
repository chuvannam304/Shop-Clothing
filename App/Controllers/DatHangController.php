<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/HoaDon.php';
require_once __DIR__ . '/../Models/GioHang.php';
require_once __DIR__ . '/../Models/KhachHang.php';

class DatHangController
{
    private $conn;
    private $hoaDonModel;
    private $gioHangModel;
    private $khachHangModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $conn;

        $this->conn = $conn;
        $this->hoaDonModel = new HoaDon();
        $this->gioHangModel = new GioHang();
        $this->khachHangModel = new KhachHang();
    }

    private function checkLogin()
    {
        if (empty($_SESSION['taiKhoan']['MaTK'])) {
            header('Location: index.php?controller=taikhoan&action=login');
            exit;
        }

        return $_SESSION['taiKhoan']['MaTK'];
    }

    private function getAddresses($maKH)
    {
        $sql = "SELECT *
                FROM DiaChi
                WHERE MaKH = :MaKH
                ORDER BY MacDinh DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':MaKH' => $maKH
        ]);

        return $stmt->fetchAll();
    }

    private function getAddress($maDiaChi, $maKH)
    {
        $sql = "SELECT *
                FROM DiaChi
                WHERE MaDiaChi = :MaDiaChi
                AND MaKH = :MaKH
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':MaDiaChi' => $maDiaChi,
            ':MaKH' => $maKH
        ]);

        return $stmt->fetch();
    }

    private function buildAddress($diaChi)
    {
        $parts = [
            $diaChi['DiaChiChiTiet'] ?? '',
            $diaChi['PhuongXa'] ?? '',
            $diaChi['QuanHuyen'] ?? '',
            $diaChi['TinhThanh'] ?? ''
        ];

        $parts = array_filter($parts);

        return implode(', ', $parts);
    }

    public function index()
    {
        $maTK = $this->checkLogin();

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        if (!$khachHang) {
            header('Location: index.php?controller=khachhang&action=profile');
            exit;
        }

        $maKH = $khachHang['MaKH'];

        $gioHang = $this->gioHangModel->getActiveCart($maKH);

        if (!$gioHang) {
            header('Location: index.php?controller=giohang&action=index');
            exit;
        }

        $cartItems = $this->gioHangModel->getCartItems($gioHang['MaGioHang']);

        if (empty($cartItems)) {
            header('Location: index.php?controller=giohang&action=index');
            exit;
        }

        $addresses = $this->getAddresses($maKH);

        if (empty($addresses)) {
            header('Location: index.php?controller=diachi&action=create');
            exit;
        }

        $paymentMethods = $this->hoaDonModel->getPaymentMethods();

        $tongTien = 0;

        foreach ($cartItems as $item) {
            $tongTien += (float) $item['GiaBan'] * (int) $item['SoLuong'];
        }

        $tongTien = 0;

        foreach ($cartItems as $item) {
            $tongTien += (float) $item['GiaBan'] * (int) $item['SoLuong'];
        }

        $phiVanChuyen = 0;
        $tienGiam = 0;
        $thanhTien = $tongTien + $phiVanChuyen - $tienGiam;

        $title = 'Thanh toán - NamShop';

        require __DIR__ . '/../Views/cart/checkout.php';
    }

    public function store()
    {
        $maTK = $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=dathang&action=index');
            exit;
        }

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        if (!$khachHang) {
            header('Location: index.php?controller=khachhang&action=profile');
            exit;
        }

        $maKH = $khachHang['MaKH'];

        $maDiaChi = trim($_POST['MaDiaChi'] ?? '');
        $maPhuongThuc = trim($_POST['MaPhuongThuc'] ?? '');
        $ghiChu = trim($_POST['GhiChu'] ?? '');

        if ($maDiaChi == '' || $maPhuongThuc == '') {
            header('Location: index.php?controller=dathang&action=index');
            exit;
        }

        $diaChi = $this->getAddress($maDiaChi, $maKH);

        if (!$diaChi) {
            die('Địa chỉ giao hàng không hợp lệ.');
        }

        $gioHang = $this->gioHangModel->getActiveCart($maKH);

        if (!$gioHang) {
            die('Giỏ hàng không tồn tại.');
        }

        $cartItems = $this->gioHangModel->getCartItems($gioHang['MaGioHang']);

        if (empty($cartItems)) {
            die('Giỏ hàng đang trống.');
        }

        $trangThai = $this->hoaDonModel->getFirstOrderStatus();

        if (!$trangThai) {
            die('Chưa có trạng thái đơn hàng.');
        }

        $tongTien = 0;

        foreach ($cartItems as $item) {
            $soLuong = (int) $item['SoLuong'];
            $soLuongTon = (int) $item['SoLuongTon'];

            if ($soLuong > $soLuongTon) {
                die('Sản phẩm ' . htmlspecialchars($item['TenSP']) . ' không còn đủ hàng.');
            }

            $tongTien += (float) $item['GiaBan'] * $soLuong;
        }

        $phiVanChuyen = 0;
        $tienGiam = 0;
        $thanhTien = $tongTien;

        try {
            $this->hoaDonModel->beginTransaction();

            $maHD = $this->hoaDonModel->generateMaHD();

            $this->hoaDonModel->createOrder([
                'MaHD' => $maHD,
                'MaKH' => $maKH,
                'MaDiaChi' => $maDiaChi,
                'MaPhuongThuc' => $maPhuongThuc,
                'MaTrangThai' => $trangThai['MaTrangThai'],
                'MaGiamGia' => null,
                'HoTenNguoiNhan' => $diaChi['HoTenNguoiNhan'],
                'SoDienThoaiNhan' => $diaChi['SoDienThoai'],
                'DiaChiGiaoHang' => $this->buildAddress($diaChi),
                'TongTien' => $tongTien,
                'TienGiam' => $tienGiam,
                'PhiVanChuyen' => $phiVanChuyen,
                'ThanhTien' => $thanhTien,
                'TrangThaiThanhToan' => 'ChuaThanhToan',
                'GhiChu' => $ghiChu != '' ? $ghiChu : null
            ]);

            foreach ($cartItems as $item) {
                $soLuong = (int) $item['SoLuong'];
                $donGia = (float) $item['GiaBan'];

                $result = $this->hoaDonModel->decreaseStock(
                    $item['MaBienThe'],
                    $soLuong
                );

                if (!$result) {
                    throw new Exception('Không đủ số lượng tồn kho.');
                }

                $this->hoaDonModel->createOrderDetail([
                    'MaCTHD' => $this->hoaDonModel->generateMaCTHD(),
                    'MaHD' => $maHD,
                    'MaBienThe' => $item['MaBienThe'],
                    'SoLuong' => $soLuong,
                    'DonGia' => $donGia,
                    'ThanhTien' => $donGia * $soLuong
                ]);
            }

            $this->gioHangModel->clearCart($gioHang['MaGioHang']);

            $this->hoaDonModel->commit();

            header('Location: index.php?controller=khachhang&action=orders&success=1');
            exit;
        } catch (Throwable $e) {
            $this->hoaDonModel->rollBack();

            die('Đặt hàng thất bại: ' . htmlspecialchars($e->getMessage()));
        }
    }
}
