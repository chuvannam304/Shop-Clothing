<?php

require_once __DIR__ . '/../Models/NhanHieu.php';

class NhanHieuController
{
    private $nhanHieuModel;

    public function __construct()
    {
        $this->nhanHieuModel = new NhanHieu();
    }

    // =========================
    // DANH SÁCH NHÃN HIỆU
    // =========================
    public function index()
    {
        $dsNhanHieu = $this->nhanHieuModel->getAll();

        $title = 'Quản lý nhãn hiệu';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/brand/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // =========================
    // FORM THÊM
    // =========================
    public function create()
    {
        $title = 'Thêm nhãn hiệu';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/brand/create.php';

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

        $logo = null;

        if (isset($_FILES['Logo']) && $_FILES['Logo']['error'] == 0) {

            $file = $_FILES['Logo'];

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                die('Logo chỉ được sử dụng JPG, JPEG, PNG hoặc WEBP.');
            }

            if ($file['size'] > 5 * 1024 * 1024) {
                die('Logo không được vượt quá 5MB.');
            }

            $uploadDir = __DIR__ . '/../../public/uploads/brands/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $logo = time() . '_' . uniqid() . '.' . $extension;

            if (!move_uploaded_file($file['tmp_name'], $uploadDir . $logo)) {
                die('Không thể upload logo.');
            }
        }

        $data = [
            'MaNhanHieu' => $this->nhanHieuModel->generateMaNhanHieu(),
            'TenNhanHieu' => trim($_POST['TenNhanHieu'] ?? ''),
            'Logo' => $logo,
            'MoTa' => trim($_POST['MoTa'] ?? ''),
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];

        if ($data['TenNhanHieu'] == '') {
            die('Tên nhãn hiệu không được để trống.');
        }

        $this->nhanHieuModel->create($data);

        header('Location: index.php?controller=nhanhieu&action=index');
        exit;
    }
    // =========================
    // FORM SỬA
    // =========================
    public function edit()
    {
        $maNhanHieu = $_GET['id'] ?? '';

        if ($maNhanHieu == '') {
            die('Không tìm thấy mã nhãn hiệu.');
        }

        $nhanHieu = $this->nhanHieuModel->getById($maNhanHieu);

        if (!$nhanHieu) {
            die('Nhãn hiệu không tồn tại.');
        }

        $title = 'Sửa nhãn hiệu';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/brand/edit.php';

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

        $maNhanHieu = $_POST['MaNhanHieu'] ?? '';

        if ($maNhanHieu == '') {
            die('Không tìm thấy mã nhãn hiệu.');
        }

        $nhanHieu = $this->nhanHieuModel->getById($maNhanHieu);

        if (!$nhanHieu) {
            die('Nhãn hiệu không tồn tại.');
        }

        // Mặc định giữ logo cũ
        $logo = $nhanHieu['Logo'];

        // Nếu có chọn logo mới
        if (isset($_FILES['Logo']) && $_FILES['Logo']['error'] == 0) {

            $file = $_FILES['Logo'];

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                die('Logo chỉ được sử dụng JPG, JPEG, PNG hoặc WEBP.');
            }

            if ($file['size'] > 5 * 1024 * 1024) {
                die('Logo không được vượt quá 5MB.');
            }

            $uploadDir = __DIR__ . '/../../public/uploads/brands/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $logoMoi = time() . '_' . uniqid() . '.' . $extension;

            if (!move_uploaded_file($file['tmp_name'], $uploadDir . $logoMoi)) {
                die('Không thể upload logo mới.');
            }

            // Xóa logo cũ
            if (!empty($nhanHieu['Logo'])) {
                $logoCu = $uploadDir . $nhanHieu['Logo'];

                if (file_exists($logoCu)) {
                    unlink($logoCu);
                }
            }

            $logo = $logoMoi;
        }

        $data = [
            'MaNhanHieu' => $maNhanHieu,
            'TenNhanHieu' => trim($_POST['TenNhanHieu'] ?? ''),
            'Logo' => $logo,
            'MoTa' => trim($_POST['MoTa'] ?? ''),
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];

        if ($data['TenNhanHieu'] == '') {
            die('Tên nhãn hiệu không được để trống.');
        }

        $this->nhanHieuModel->update($data);

        header('Location: index.php?controller=nhanhieu&action=index');
        exit;
    }
    // =========================
    // XÓA NHÃN HIỆU
    // =========================
    public function delete()
    {
        $maNhanHieu = $_GET['id'] ?? '';

        if ($maNhanHieu == '') {
            die('Không tìm thấy mã nhãn hiệu.');
        }

        $nhanHieu = $this->nhanHieuModel->getById($maNhanHieu);

        if (!$nhanHieu) {
            die('Nhãn hiệu không tồn tại.');
        }

        try {
            $this->nhanHieuModel->delete($maNhanHieu);

            header('Location: index.php?controller=nhanhieu&action=index');
            exit;
        } catch (PDOException $e) {
            die('Không thể xóa nhãn hiệu này vì đang có sản phẩm sử dụng.');
        }
    }
}
