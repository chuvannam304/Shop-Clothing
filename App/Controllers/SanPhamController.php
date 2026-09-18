<?php

require_once __DIR__ . '/../Models/SanPham.php';
require_once __DIR__ . '/../Models/Loai.php';
require_once __DIR__ . '/../Models/NhanHieu.php';

class SanPhamController
{
    private $sanPhamModel;
    private $loaiModel;
    private $nhanHieuModel;

    public function __construct()
    {
        $this->sanPhamModel = new SanPham();
        $this->loaiModel = new Loai();
        $this->nhanHieuModel = new NhanHieu();
    }

    // DANH SÁCH SẢN PHẨM
    public function index()
    {
        $dsSanPham = $this->sanPhamModel->getAll();

        $title = 'Quản lý sản phẩm';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/product/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // FORM THÊM SẢN PHẨM
    public function create()
    {
        $dsLoai = $this->loaiModel->getActive();
        $dsNhanHieu = $this->nhanHieuModel->getActive();

        $title = 'Thêm sản phẩm';
        $activeMenu = 'sanpham';
        $productTab = 'sanpham';
        $view = __DIR__ . '/../Views/admin/product/create.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // XỬ LÝ THÊM SẢN PHẨM
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }
        $data = [
            'MaSP' => $this->sanPhamModel->generateMaSP(),
            'MaLoai' => $_POST['MaLoai'] ?? '',
            'MaNhanHieu' => $_POST['MaNhanHieu'] ?? '',
            'TenSP' => trim($_POST['TenSP'] ?? ''),
            'MoTa' => trim($_POST['MoTa'] ?? ''),
            'ChatLieu' => trim($_POST['ChatLieu'] ?? ''),
            'GioiTinh' => $_POST['GioiTinh'] ?? null,
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];
        if ($data['TenSP'] == '') {
            die('Tên sản phẩm không được để trống.');
        }
        if ($data['MaLoai'] == '') {
            die('Vui lòng chọn danh mục.');
        }
        if ($data['MaNhanHieu'] == '') {
            die('Vui lòng chọn nhãn hiệu.');
        }
        if ($data['GioiTinh'] == '') {
            die('Vui lòng chọn giới tính.');
        }

        $this->sanPhamModel->create($data);
        header('Location: index.php?controller=sanpham&action=index');
        exit;
    }

    // FORM SỬA SẢN PHẨM

    public function edit()
    {
        $maSP = $_GET['id'] ?? '';

        if ($maSP == '') {
            die('Không tìm thấy mã sản phẩm.');
        }

        $sanPham = $this->sanPhamModel->getById($maSP);

        if (!$sanPham) {
            die('Sản phẩm không tồn tại.');
        }

        $dsLoai = $this->loaiModel->getActive();
        $dsNhanHieu = $this->nhanHieuModel->getActive();

        $title = 'Sửa sản phẩm';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/product/edit.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }
    // XỬ LÝ SỬA SẢN PHẨM

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $data = [
            'MaSP' => $_POST['MaSP'] ?? '',
            'MaLoai' => $_POST['MaLoai'] ?? '',
            'MaNhanHieu' => $_POST['MaNhanHieu'] ?? '',
            'TenSP' => trim($_POST['TenSP'] ?? ''),
            'MoTa' => trim($_POST['MoTa'] ?? ''),
            'ChatLieu' => trim($_POST['ChatLieu'] ?? ''),
            'GioiTinh' => $_POST['GioiTinh'] ?? '',
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];

        if ($data['MaSP'] == '') {
            die('Không tìm thấy mã sản phẩm.');
        }

        if ($data['TenSP'] == '') {
            die('Tên sản phẩm không được để trống.');
        }

        if ($data['MaLoai'] == '') {
            die('Vui lòng chọn danh mục.');
        }

        if ($data['MaNhanHieu'] == '') {
            die('Vui lòng chọn nhãn hiệu.');
        }

        if ($data['GioiTinh'] == '') {
            die('Vui lòng chọn giới tính.');
        }

        $sanPham = $this->sanPhamModel->getById($data['MaSP']);

        if (!$sanPham) {
            die('Sản phẩm không tồn tại.');
        }

        $this->sanPhamModel->update($data);

        header('Location: index.php?controller=sanpham&action=index');
        exit;
    }

    // XÓA SẢN PHẨM

    public function delete()
    {
        $maSP = $_GET['id'] ?? '';

        if ($maSP == '') {
            die('Không tìm thấy mã sản phẩm.');
        }

        $sanPham = $this->sanPhamModel->getById($maSP);

        if (!$sanPham) {
            die('Sản phẩm không tồn tại.');
        }

        try {
            $this->sanPhamModel->delete($maSP);

            header('Location: index.php?controller=sanpham&action=index');
            exit;
        } catch (PDOException $e) {
            die('Không thể xóa sản phẩm vì đang có dữ liệu liên quan.');
        }
    }
}
