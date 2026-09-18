<?php

require_once __DIR__ . '/../Models/Loai.php';

class LoaiController
{
    private $loaiModel;

    public function __construct()
    {
        $this->loaiModel = new Loai();
    }

    public function index()
    {
        $dsLoai = $this->loaiModel->getAll();

        $title = 'Quản lý danh mục';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/loai/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    public function create()
    {
        $title = 'Thêm danh mục';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/loai/create.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $data = [
            'MaLoai' => $this->loaiModel->generateMaLoai(),
            'TenLoai' => trim($_POST['TenLoai'] ?? ''),
            'MoTa' => trim($_POST['MoTa'] ?? ''),
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];
        if ($data['TenLoai'] == '') {
            die('Tên loại không được để trống.');
        }
        $this->loaiModel->create($data);
        header('Location: index.php?controller=loai&action=index');
        exit;
    }

    public function edit()
    {
        $maLoai = $_GET['id'] ?? '';

        if ($maLoai == '') {
            die('Không tìm thấy mã loại.');
        }

        $loai = $this->loaiModel->getById($maLoai);

        if (!$loai) {
            die('Danh mục không tồn tại.');
        }

        $title = 'Sửa danh mục';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/loai/edit.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $data = [
            'MaLoai' => $_POST['MaLoai'] ?? '',
            'TenLoai' => trim($_POST['TenLoai'] ?? ''),
            'MoTa' => trim($_POST['MoTa'] ?? ''),
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];

        if ($data['MaLoai'] == '') {
            die('Không tìm thấy mã loại.');
        }

        if ($data['TenLoai'] == '') {
            die('Tên loại không được để trống.');
        }

        $this->loaiModel->update($data);

        header('Location: index.php?controller=loai&action=index');
        exit;
    }

    public function delete()
    {
        $maLoai = $_GET['id'] ?? '';

        if ($maLoai == '') {
            die('Không tìm thấy mã loại.');
        }

        $loai = $this->loaiModel->getById($maLoai);

        if (!$loai) {
            die('Danh mục không tồn tại.');
        }

        try {
            $this->loaiModel->delete($maLoai);

            header('Location: index.php?controller=loai&action=index');
            exit;
        } catch (PDOException $e) {
            die('Không thể xóa danh mục vì đang có sản phẩm sử dụng.');
        }
    }
}
