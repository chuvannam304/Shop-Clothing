<?php

require_once __DIR__ . '/../Models/GioHang.php';
require_once __DIR__ . '/../Models/KhachHang.php';

class GioHangController
{
    private $gioHangModel;
    private $khachHangModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->gioHangModel = new GioHang();
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

    // KIỂM TRA THÔNG TIN GIAO HÀNG
    private function checkProfile($maKH)
    {
        global $conn;

        $sql = "SELECT *
                FROM diachi
                WHERE MaKH = :MaKH
                  AND TRIM(SoDienThoai) <> ''
                  AND TRIM(DiaChiChiTiet) <> ''
                ORDER BY MacDinh DESC
                LIMIT 1";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':MaKH' => $maKH
        ]);

        return $stmt->fetch();
    }

    // THÊM VÀO GIỎ HÀNG
    public function add()
    {
        header('Content-Type: application/json; charset=utf-8');

        // Chưa đăng nhập
        if (!isset($_SESSION['taiKhoan'])) {
            echo json_encode([
                'success' => false,
                'loginRequired' => true,
                'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.'
            ]);
            exit;
        }
        // Kiểm tra địa chỉ giao hàng

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ.'
            ]);
            exit;
        }

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        // Lấy khách hàng đang đăng nhập
        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        if (!$khachHang) {
            echo json_encode([
                'success' => false,
                'profileRequired' => true,
                'message' => 'Không tìm thấy thông tin khách hàng.'
            ]);
            exit;
        }

        $maKH = $khachHang['MaKH'];
        // Kiểm tra địa chỉ giao hàng
        $diaChi = $this->checkProfile($maKH);

        if (!$diaChi) {
            echo json_encode([
                'success' => false,
                'addressRequired' => true,
                'message' => 'Bạn cần cập nhật địa chỉ và số điện thoại trước khi thêm sản phẩm vào giỏ hàng.'
            ]);
            exit;
        }
        $maBienThe = trim($_POST['MaBienThe'] ?? '');
        $soLuong = (int) ($_POST['SoLuong'] ?? 1);

        if ($maBienThe == '') {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng chọn màu sắc và size.'
            ]);
            exit;
        }

        if ($soLuong < 1) {
            $soLuong = 1;
        }

        // Lấy giỏ hàng hiện tại
        $gioHang = $this->gioHangModel->getActiveCart($maKH);

        // Chưa có giỏ thì tạo
        if (!$gioHang) {
            $maGioHang = $this->gioHangModel->createCart($maKH);
        } else {
            $maGioHang = $gioHang['MaGioHang'];
        }

        // Kiểm tra biến thể đã có trong giỏ chưa
        $chiTiet = $this->gioHangModel->getCartItem(
            $maGioHang,
            $maBienThe
        );

        if ($chiTiet) {

            // Đã có -> cộng số lượng
            $soLuongMoi = (int) $chiTiet['SoLuong'] + $soLuong;

            $this->gioHangModel->updateItemQuantity(
                $chiTiet['MaCTGH'],
                $soLuongMoi
            );
        } else {

            // Chưa có -> thêm mới
            $this->gioHangModel->addItem(
                $maGioHang,
                $maBienThe,
                $soLuong
            );
        }

        // Lấy tổng số lượng mới để cập nhật badge
        $cartCount = $this->gioHangModel->countCartItems($maKH);

        echo json_encode([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng.',
            'cartCount' => $cartCount
        ]);

        exit;
    }


    // HIỂN THỊ GIỎ HÀNG
    public function index()
    {
        $this->checkLogin();

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        // Lấy khách hàng theo tài khoản
        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        if (!$khachHang) {
            header('Location: index.php?controller=khachhang&action=profile');
            exit;
        }

        $maKH = $khachHang['MaKH'];

        // Lấy giỏ hàng đang hoạt động
        $gioHang = $this->gioHangModel->getActiveCart($maKH);

        // Danh sách sản phẩm trong giỏ
        $cartItems = [];

        if ($gioHang) {
            $cartItems = $this->gioHangModel->getCartItems(
                $gioHang['MaGioHang']
            );
        }

        // Tính tổng tiền
        $tongTien = 0;

        foreach ($cartItems as $item) {
            $tongTien += (float) $item['GiaBan'] * (int) $item['SoLuong'];
        }

        $title = 'Giỏ hàng';

        require __DIR__ . '/../Views/cart/index.php';
    }
    // CẬP NHẬT SỐ LƯỢNG SẢN PHẨM TRONG GIỎ
    public function updateQuantity()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['taiKhoan'])) {
            echo json_encode([
                'success' => false,
                'loginRequired' => true,
                'message' => 'Vui lòng đăng nhập.'
            ]);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ.'
            ]);
            exit;
        }

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        if (!$khachHang) {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy khách hàng.'
            ]);
            exit;
        }

        $maKH = $khachHang['MaKH'];

        $gioHang = $this->gioHangModel->getActiveCart($maKH);

        if (!$gioHang) {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy giỏ hàng.'
            ]);
            exit;
        }

        $maCTGH = trim($_POST['MaCTGH'] ?? '');
        $soLuong = (int) ($_POST['SoLuong'] ?? 0);

        if ($maCTGH == '' || $soLuong < 1) {
            echo json_encode([
                'success' => false,
                'message' => 'Số lượng không hợp lệ.'
            ]);
            exit;
        }

        // Kiểm tra sản phẩm có thật sự thuộc giỏ của tài khoản này không
        $cartItems = $this->gioHangModel->getCartItems(
            $gioHang['MaGioHang']
        );

        $itemCanUpdate = null;

        foreach ($cartItems as $item) {
            if ($item['MaCTGH'] == $maCTGH) {
                $itemCanUpdate = $item;
                break;
            }
        }

        if (!$itemCanUpdate) {
            echo json_encode([
                'success' => false,
                'message' => 'Sản phẩm không thuộc giỏ hàng này.'
            ]);
            exit;
        }

        // Không được tăng vượt tồn kho
        $soLuongTon = (int) $itemCanUpdate['SoLuongTon'];

        if ($soLuong > $soLuongTon) {
            echo json_encode([
                'success' => false,
                'message' => 'Số lượng vượt quá tồn kho.',
                'maxQuantity' => $soLuongTon
            ]);
            exit;
        }

        $this->gioHangModel->updateItemQuantity(
            $maCTGH,
            $soLuong
        );

        // Lấy lại giỏ để tính tổng tiền mới
        $cartItems = $this->gioHangModel->getCartItems(
            $gioHang['MaGioHang']
        );

        $tongTien = 0;
        $thanhTien = 0;

        foreach ($cartItems as $item) {

            $itemTotal =
                (float) $item['GiaBan'] *
                (int) $item['SoLuong'];

            $tongTien += $itemTotal;

            if ($item['MaCTGH'] == $maCTGH) {
                $thanhTien = $itemTotal;
            }
        }

        $cartCount = $this->gioHangModel->countCartItems($maKH);

        echo json_encode([
            'success' => true,
            'soLuong' => $soLuong,
            'thanhTien' => $thanhTien,
            'tongTien' => $tongTien,
            'cartCount' => $cartCount
        ]);

        exit;
    }


    // XÓA SẢN PHẨM KHỎI GIỎ
    public function delete()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['taiKhoan'])) {
            echo json_encode([
                'success' => false,
                'loginRequired' => true,
                'message' => 'Vui lòng đăng nhập.'
            ]);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ.'
            ]);
            exit;
        }

        $maTK = $_SESSION['taiKhoan']['MaTK'];

        $khachHang = $this->khachHangModel->getByMaTK($maTK);

        if (!$khachHang) {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy khách hàng.'
            ]);
            exit;
        }

        $maKH = $khachHang['MaKH'];

        $gioHang = $this->gioHangModel->getActiveCart($maKH);

        if (!$gioHang) {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy giỏ hàng.'
            ]);
            exit;
        }

        $maCTGH = trim($_POST['MaCTGH'] ?? '');

        if ($maCTGH == '') {
            echo json_encode([
                'success' => false,
                'message' => 'Sản phẩm không hợp lệ.'
            ]);
            exit;
        }

        // deleteItem phải nhận cả MaCTGH và MaGioHang
        $this->gioHangModel->deleteItem(
            $maCTGH,
            $gioHang['MaGioHang']
        );

        // Lấy lại giỏ sau khi xóa
        $cartItems = $this->gioHangModel->getCartItems(
            $gioHang['MaGioHang']
        );

        $tongTien = 0;

        foreach ($cartItems as $item) {
            $tongTien +=
                (float) $item['GiaBan'] *
                (int) $item['SoLuong'];
        }

        $cartCount = $this->gioHangModel->countCartItems($maKH);

        echo json_encode([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
            'tongTien' => $tongTien,
            'cartCount' => $cartCount
        ]);

        exit;
    }
}
