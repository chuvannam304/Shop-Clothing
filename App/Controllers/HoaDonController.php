<?php

require_once __DIR__ . '/../Models/HoaDon.php';
require_once __DIR__ . '/../Models/ChiTietHoaDon.php';
require_once __DIR__ . '/../Models/TrangThaiDonHang.php';

class HoaDonController
{
    private $hoaDonModel;
    private $chiTietHoaDonModel;
    private $trangThaiModel;

    public function __construct()
    {
        $this->hoaDonModel = new HoaDon();
        $this->chiTietHoaDonModel = new ChiTietHoaDon();
        $this->trangThaiModel = new TrangThaiDonHang();
    }

    public function index()
    {
        $keyword = trim($_GET['keyword'] ?? '');

        if ($keyword != '') {
            $hoaDons = $this->hoaDonModel->search($keyword);
        } else {
            $hoaDons = $this->hoaDonModel->getAll();
        }

        $trangThais = $this->trangThaiModel->getAll();

        $title = 'Quản lý đơn hàng';
        $activeMenu = 'hoadon';
        $view = __DIR__ . '/../Views/admin/hoadon/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    public function detail()
    {
        $maHD = $_GET['id'] ?? '';

        if ($maHD == '') {
            header('Location: index.php?controller=hoadon&action=index');
            exit;
        }

        $hoaDon = $this->hoaDonModel->getById($maHD);

        if (!$hoaDon) {
            header('Location: index.php?controller=hoadon&action=index');
            exit;
        }

        $chiTietHoaDons = $this->chiTietHoaDonModel->getByMaHD($maHD);
        $trangThais = $this->trangThaiModel->getAll();

        $title = 'Chi tiết đơn hàng';
        $activeMenu = 'hoadon';
        $view = __DIR__ . '/../Views/admin/hoadon/detail.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=hoadon&action=index');
            exit;
        }

        $maHD = trim($_POST['MaHD'] ?? '');
        $maTrangThai = trim($_POST['MaTrangThai'] ?? '');

        if ($maHD == '' || $maTrangThai == '') {
            header('Location: index.php?controller=hoadon&action=index');
            exit;
        }

        $hoaDon = $this->hoaDonModel->getById($maHD);
        $trangThai = $this->trangThaiModel->getById($maTrangThai);

        if (!$hoaDon || !$trangThai) {
            header('Location: index.php?controller=hoadon&action=index');
            exit;
        }

        $this->hoaDonModel->updateTrangThai($maHD, $maTrangThai);

        header('Location: index.php?controller=hoadon&action=detail&id=' . urlencode($maHD) . '&success=status');
        exit;
    }

    public function updatePayment()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: index.php?controller=hoadon&action=index');
            exit;
        }

        $maHD = trim($_POST['MaHD'] ?? '');
        $trangThaiThanhToan = trim($_POST['TrangThaiThanhToan'] ?? '');

        if ($maHD == '' || $trangThaiThanhToan == '') {
            header('Location: index.php?controller=hoadon&action=index');
            exit;
        }

        $hoaDon = $this->hoaDonModel->getById($maHD);

        if (!$hoaDon) {
            header('Location: index.php?controller=hoadon&action=index');
            exit;
        }

        $this->hoaDonModel->updateTrangThaiThanhToan($maHD, $trangThaiThanhToan);

        header('Location: index.php?controller=hoadon&action=detail&id=' . urlencode($maHD) . '&success=payment');
        exit;
    }
}