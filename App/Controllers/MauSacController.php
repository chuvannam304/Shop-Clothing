<?php

require_once __DIR__ . '/../Models/MauSac.php';

class MauSacController
{
    private $mauSacModel;

    public function __construct()
    {
        $this->mauSacModel = new MauSac();
    }

    // =========================
    // DANH SÁCH MÀU SẮC
    // =========================
    public function index()
    {
        $dsMauSac = $this->mauSacModel->getAll();

        $title = 'Quản lý màu sắc';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/color/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // =========================
    // FORM THÊM
    // =========================
    public function create()
    {
        $title = 'Thêm màu sắc';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/color/create.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // =========================
    // XỬ LÝ THÊM
    // =========================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $data = [
            'MaMau' => $this->mauSacModel->generateMaMau(),
            'TenMau' => trim($_POST['TenMau'] ?? ''),
            'MaHex' => trim($_POST['MaHex'] ?? ''),
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];


        if ($data['TenMau'] == '') {
            die('Tên màu không được để trống.');
        }


        $this->mauSacModel->create($data);

        header('Location: index.php?controller=mausac&action=index');
        exit;
    }

    // =========================
    // FORM SỬA
    // =========================
    public function edit()
    {
        $maMau = $_GET['id'] ?? '';

        if ($maMau == '') {
            die('Không tìm thấy mã màu.');
        }

        $mauSac = $this->mauSacModel->getById($maMau);

        if (!$mauSac) {
            die('Màu sắc không tồn tại.');
        }

        $title = 'Sửa màu sắc';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/color/edit.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // =========================
    // XỬ LÝ SỬA
    // =========================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $data = [
            'MaMau' => $_POST['MaMau'] ?? '',
            'TenMau' => trim($_POST['TenMau'] ?? ''),
            'MaHex' => trim($_POST['MaHex'] ?? ''),
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];

        if ($data['MaMau'] == '') {
            die('Không tìm thấy mã màu.');
        }

        if ($data['TenMau'] == '') {
            die('Tên màu không được để trống.');
        }

        $this->mauSacModel->update($data);

        header('Location: index.php?controller=mausac&action=index');
        exit;
    }

    // =========================
    // XÓA MÀU
    // =========================
    public function delete()
    {
        $maMau = $_GET['id'] ?? '';

        if ($maMau == '') {
            die('Không tìm thấy mã màu.');
        }

        $mauSac = $this->mauSacModel->getById($maMau);

        if (!$mauSac) {
            die('Màu sắc không tồn tại.');
        }

        try {
            $this->mauSacModel->delete($maMau);

            header('Location: index.php?controller=mausac&action=index');
            exit;
        } catch (PDOException $e) {
            die('Không thể xóa màu này vì đang có biến thể sản phẩm sử dụng.');
        }
    }
}
