<?php

require_once __DIR__ . '/../Models/Size.php';

class SizeController
{
    private $sizeModel;

    public function __construct()
    {
        $this->sizeModel = new Size();
    }

    // DANH SÁCH SIZE
    public function index()
    {
        $dsSize = $this->sizeModel->getAll();

        $title = 'Quản lý size';
        $activeMenu = 'sanpham';
        $productTab = 'size';
        $view = __DIR__ . '/../Views/admin/size/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // FORM THÊM
    public function create()
    {
        $title = 'Thêm size';
        $activeMenu = 'sanpham';
        $productTab = 'size';
        $view = __DIR__ . '/../Views/admin/size/create.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // XỬ LÝ THÊM
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $data = [
            'MaSize' => $this->sizeModel->generateMaSize(),
            'TenSize' => trim($_POST['TenSize'] ?? ''),
            'MoTa' => trim($_POST['MoTa'] ?? '')
        ];

        if ($data['TenSize'] == '') {
            die('Tên size không được để trống.');
        }

        $this->sizeModel->create($data);

        header('Location: index.php?controller=size&action=index');
        exit;
    }

    // FORM SỬA
    public function edit()
    {
        $maSize = $_GET['id'] ?? '';

        if ($maSize == '') {
            die('Không tìm thấy mã size.');
        }

        $size = $this->sizeModel->getById($maSize);

        if (!$size) {
            die('Size không tồn tại.');
        }

        $title = 'Sửa size';
        $activeMenu = 'sanpham';
        $productTab = 'size';
        $view = __DIR__ . '/../Views/admin/size/edit.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // XỬ LÝ SỬA
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $data = [
            'MaSize' => $_POST['MaSize'] ?? '',
            'TenSize' => trim($_POST['TenSize'] ?? ''),
            'MoTa' => trim($_POST['MoTa'] ?? '')
        ];

        if ($data['MaSize'] == '') {
            die('Không tìm thấy mã size.');
        }

        if ($data['TenSize'] == '') {
            die('Tên size không được để trống.');
        }

        $size = $this->sizeModel->getById($data['MaSize']);

        if (!$size) {
            die('Size không tồn tại.');
        }

        $this->sizeModel->update($data);

        header('Location: index.php?controller=size&action=index');
        exit;
    }

    // =========================
    // XÓA SIZE
    // =========================
    public function delete()
    {
        $maSize = $_GET['id'] ?? '';

        if ($maSize == '') {
            die('Không tìm thấy mã size.');
        }

        $size = $this->sizeModel->getById($maSize);

        if (!$size) {
            die('Size không tồn tại.');
        }

        try {
            $this->sizeModel->delete($maSize);

            header('Location: index.php?controller=size&action=index');
            exit;
        } catch (PDOException $e) {
            die('Không thể xóa size này vì đang có biến thể sản phẩm sử dụng.');
        }
    }
}
