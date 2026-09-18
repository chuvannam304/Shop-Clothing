<?php

require_once __DIR__ . '/../Models/HinhAnhSanPham.php';
require_once __DIR__ . '/../Models/SanPham.php';

class HinhAnhSanPhamController
{
    private $hinhAnhModel;
    private $sanPhamModel;

    public function __construct()
    {
        $this->hinhAnhModel = new HinhAnhSanPham();
        $this->sanPhamModel = new SanPham();
    }

    // =========================
    // DANH SÁCH HÌNH ẢNH
    // =========================
    public function index()
    {
        $maSP = $_GET['sp'] ?? '';

        if ($maSP == '') {
            die('Không tìm thấy mã sản phẩm.');
        }

        $sanPham = $this->sanPhamModel->getById($maSP);

        if (!$sanPham) {
            die('Sản phẩm không tồn tại.');
        }

        $dsHinhAnh = $this->hinhAnhModel->getBySanPham($maSP);

        $title = 'Hình ảnh sản phẩm';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/product/image/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // =========================
    // FORM THÊM HÌNH
    // =========================
    public function create()
    {
        $maSP = $_GET['sp'] ?? '';

        if ($maSP == '') {
            die('Không tìm thấy mã sản phẩm.');
        }

        $sanPham = $this->sanPhamModel->getById($maSP);

        if (!$sanPham) {
            die('Sản phẩm không tồn tại.');
        }

        $title = 'Thêm hình ảnh';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/product/image/create.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // =========================
    // XỬ LÝ THÊM HÌNH
    // =========================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $maSP = $_POST['MaSP'] ?? '';
        $maHinh = trim($_POST['MaHinh'] ?? '');
        $laAnhChinh = $_POST['LaAnhChinh'] ?? 0;
        $thuTu = $_POST['ThuTu'] ?? 1;

        if ($maSP == '') {
            die('Không tìm thấy sản phẩm.');
        }

        if ($maHinh == '') {
            die('Mã hình không được để trống.');
        }

        if ($this->hinhAnhModel->getById($maHinh)) {
            die('Mã hình đã tồn tại.');
        }

        if (!isset($_FILES['HinhAnh']) || $_FILES['HinhAnh']['error'] != 0) {
            die('Vui lòng chọn hình ảnh.');
        }

        $extension = strtolower(
            pathinfo($_FILES['HinhAnh']['name'], PATHINFO_EXTENSION)
        );

        $allow = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extension, $allow)) {
            die('Chỉ cho phép JPG, JPEG, PNG hoặc WEBP.');
        }

        if ($_FILES['HinhAnh']['size'] > 5 * 1024 * 1024) {
            die('Ảnh không được lớn hơn 5MB.');
        }

        $folder = __DIR__ . '/../../public/uploads/products/';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $target = $folder . $fileName;

        if (!move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target)) {
            die('Không thể tải hình ảnh lên.');
        }

        if ($laAnhChinh == 1) {
            $this->hinhAnhModel->resetAnhChinh($maSP);
        }

        $data = [
            'MaHinh' => $maHinh,
            'MaSP' => $maSP,
            'DuongDan' => $fileName,
            'LaAnhChinh' => $laAnhChinh,
            'ThuTu' => $thuTu
        ];

        $this->hinhAnhModel->create($data);

        header(
            'Location: index.php?controller=hinhanhsanpham&action=index&sp='
            . urlencode($maSP)
        );
        exit;
    }

    // =========================
    // FORM SỬA HÌNH
    // =========================
    public function edit()
    {
        $maHinh = $_GET['id'] ?? '';

        if ($maHinh == '') {
            die('Không tìm thấy mã hình.');
        }

        $hinhAnh = $this->hinhAnhModel->getById($maHinh);

        if (!$hinhAnh) {
            die('Hình ảnh không tồn tại.');
        }

        $sanPham = $this->sanPhamModel->getById($hinhAnh['MaSP']);

        $title = 'Sửa hình ảnh';
        $activeMenu = 'sanpham';
        $view = __DIR__ . '/../Views/admin/product/image/edit.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // =========================
    // XỬ LÝ SỬA HÌNH
    // =========================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $maHinh = $_POST['MaHinh'] ?? '';

        $hinhAnhCu = $this->hinhAnhModel->getById($maHinh);

        if (!$hinhAnhCu) {
            die('Hình ảnh không tồn tại.');
        }

        $maSP = $hinhAnhCu['MaSP'];
        $duongDan = $hinhAnhCu['DuongDan'];
        $laAnhChinh = $_POST['LaAnhChinh'] ?? 0;
        $thuTu = $_POST['ThuTu'] ?? 1;

        // Nếu chọn ảnh mới
        if (
            isset($_FILES['HinhAnh']) &&
            $_FILES['HinhAnh']['error'] == 0
        ) {
            $extension = strtolower(
                pathinfo($_FILES['HinhAnh']['name'], PATHINFO_EXTENSION)
            );

            $allow = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($extension, $allow)) {
                die('Chỉ cho phép JPG, JPEG, PNG hoặc WEBP.');
            }

            if ($_FILES['HinhAnh']['size'] > 5 * 1024 * 1024) {
                die('Ảnh không được lớn hơn 5MB.');
            }

            $folder = __DIR__ . '/../../public/uploads/products/';

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $target = $folder . $fileName;

            if (!move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target)) {
                die('Không thể tải hình ảnh lên.');
            }

            $fileCu = $folder . $duongDan;

            if (file_exists($fileCu)) {
                unlink($fileCu);
            }

            $duongDan = $fileName;
        }

        if ($laAnhChinh == 1) {
            $this->hinhAnhModel->resetAnhChinh($maSP);
        }

        $data = [
            'MaHinh' => $maHinh,
            'DuongDan' => $duongDan,
            'LaAnhChinh' => $laAnhChinh,
            'ThuTu' => $thuTu
        ];

        $this->hinhAnhModel->update($data);

        header(
            'Location: index.php?controller=hinhanhsanpham&action=index&sp='
            . urlencode($maSP)
        );
        exit;
    }

    // =========================
    // XÓA HÌNH
    // =========================
    public function delete()
    {
        $maHinh = $_GET['id'] ?? '';

        if ($maHinh == '') {
            die('Không tìm thấy mã hình.');
        }

        $hinhAnh = $this->hinhAnhModel->getById($maHinh);

        if (!$hinhAnh) {
            die('Hình ảnh không tồn tại.');
        }

        $maSP = $hinhAnh['MaSP'];

        $folder = __DIR__ . '/../../public/uploads/products/';
        $file = $folder . $hinhAnh['DuongDan'];

        if (file_exists($file)) {
            unlink($file);
        }

        $this->hinhAnhModel->delete($maHinh);

        header(
            'Location: index.php?controller=hinhanhsanpham&action=index&sp='
            . urlencode($maSP)
        );
        exit;
    }
}