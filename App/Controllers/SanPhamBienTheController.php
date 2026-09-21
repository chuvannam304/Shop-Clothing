<?php

require_once __DIR__ . '/../Models/SanPhamBienThe.php';
require_once __DIR__ . '/../Models/SanPham.php';
require_once __DIR__ . '/../Models/MauSac.php';
require_once __DIR__ . '/../Models/Size.php';

class SanPhamBienTheController
{
    private $bienTheModel;
    private $sanPhamModel;
    private $mauSacModel;
    private $sizeModel;

    public function __construct()
    {
        $this->bienTheModel = new SanPhamBienThe();
        $this->sanPhamModel = new SanPham();
        $this->mauSacModel = new MauSac();
        $this->sizeModel = new Size();
    }

    // DANH SÁCH BIẾN THỂ
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

        $dsBienThe = $this->bienTheModel->getBySanPham($maSP);

        $title = 'Biến thể sản phẩm';
        $activeMenu = 'sanpham';
        $productTab = 'sanpham';
        $view = __DIR__ . '/../Views/admin/bienthe/index.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // FORM THÊM BIẾN THỂ
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

        $dsMau = $this->mauSacModel->getActive();
        $dsSize = $this->sizeModel->getAll();

        $title = 'Thêm biến thể';
        $activeMenu = 'sanpham';
        $productTab = 'sanpham';
        $view = __DIR__ . '/../Views/admin/bienthe/create.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // XỬ LÝ THÊM BIẾN THỂ
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $data = [
            'MaBienThe' => $this->bienTheModel->generateMaBienThe(),
            'MaSP' => $_POST['MaSP'] ?? '',
            'MaMau' => $_POST['MaMau'] ?? '',
            'MaSize' => $_POST['MaSize'] ?? '',
            'MaSKU' => trim($_POST['MaSKU'] ?? ''),
            'GiaBan' => $_POST['GiaBan'] ?? '',
            'SoLuongTon' => $_POST['SoLuongTon'] ?? '',
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];

        if ($data['MaSP'] == '') {
            die('Không tìm thấy sản phẩm.');
        }

        if (!$this->sanPhamModel->getById($data['MaSP'])) {
            die('Sản phẩm không tồn tại.');
        }

        if ($data['MaMau'] == '') {
            die('Vui lòng chọn màu sắc.');
        }

        if ($data['MaSize'] == '') {
            die('Vui lòng chọn size.');
        }

        if ($data['MaSKU'] == '') {
            die('SKU không được để trống.');
        }

        if ($data['GiaBan'] === '' || !is_numeric($data['GiaBan']) || $data['GiaBan'] < 0) {
            die('Giá bán không hợp lệ.');
        }

        if ($data['SoLuongTon'] === '' || !is_numeric($data['SoLuongTon']) || $data['SoLuongTon'] < 0) {
            die('Số lượng tồn không hợp lệ.');
        }

        if ($this->bienTheModel->getBySKU($data['MaSKU'])) {
            die('SKU đã tồn tại.');
        }

        if ($this->bienTheModel->checkBienThe(
            $data['MaSP'],
            $data['MaMau'],
            $data['MaSize']
        )) {
            die('Sản phẩm đã có biến thể màu và size này.');
        }

        $this->bienTheModel->create($data);

        header('Location: index.php?controller=sanphambienthe&action=index&sp=' . urlencode($data['MaSP']));
        exit;
    }

    // FORM SỬA BIẾN THỂ
    public function edit()
    {
        $maBienThe = $_GET['id'] ?? '';

        if ($maBienThe == '') {
            die('Không tìm thấy mã biến thể.');
        }

        $bienThe = $this->bienTheModel->getById($maBienThe);

        if (!$bienThe) {
            die('Biến thể không tồn tại.');
        }

        $sanPham = $this->sanPhamModel->getById($bienThe['MaSP']);

        if (!$sanPham) {
            die('Sản phẩm không tồn tại.');
        }

        $dsMau = $this->mauSacModel->getActive();
        $dsSize = $this->sizeModel->getAll();

        $title = 'Sửa biến thể';
        $activeMenu = 'sanpham';
        $productTab = 'sanpham';
        $view = __DIR__ . '/../Views/admin/bienthe/edit.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }

    // XỬ LÝ SỬA BIẾN THỂ
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $data = [
            'MaBienThe' => $_POST['MaBienThe'] ?? '',
            'MaSP' => $_POST['MaSP'] ?? '',
            'MaMau' => $_POST['MaMau'] ?? '',
            'MaSize' => $_POST['MaSize'] ?? '',
            'MaSKU' => trim($_POST['MaSKU'] ?? ''),
            'GiaBan' => $_POST['GiaBan'] ?? '',
            'SoLuongTon' => $_POST['SoLuongTon'] ?? '',
            'TrangThai' => $_POST['TrangThai'] ?? 1
        ];

        if ($data['MaBienThe'] == '') {
            die('Không tìm thấy mã biến thể.');
        }

        $bienThe = $this->bienTheModel->getById($data['MaBienThe']);

        if (!$bienThe) {
            die('Biến thể không tồn tại.');
        }

        if ($data['MaSP'] == '') {
            die('Không tìm thấy sản phẩm.');
        }

        if ($data['MaMau'] == '') {
            die('Vui lòng chọn màu sắc.');
        }

        if ($data['MaSize'] == '') {
            die('Vui lòng chọn size.');
        }

        if ($data['MaSKU'] == '') {
            die('SKU không được để trống.');
        }

        if ($data['GiaBan'] === '' || !is_numeric($data['GiaBan']) || $data['GiaBan'] < 0) {
            die('Giá bán không hợp lệ.');
        }

        if ($data['SoLuongTon'] === '' || !is_numeric($data['SoLuongTon']) || $data['SoLuongTon'] < 0) {
            die('Số lượng tồn không hợp lệ.');
        }

        $sku = $this->bienTheModel->getBySKU($data['MaSKU']);

        if ($sku && $sku['MaBienThe'] != $data['MaBienThe']) {
            die('SKU đã tồn tại.');
        }

        $bienTheTrung = $this->bienTheModel->checkBienThe(
            $data['MaSP'],
            $data['MaMau'],
            $data['MaSize']
        );

        if ($bienTheTrung && $bienTheTrung['MaBienThe'] != $data['MaBienThe']) {
            die('Sản phẩm đã có biến thể màu và size này.');
        }

        $this->bienTheModel->update($data);

        header('Location: index.php?controller=sanphambienthe&action=index&sp=' . urlencode($data['MaSP']));
        exit;
    }

    // XÓA BIẾN THỂ
    public function delete()
    {
        $maBienThe = $_GET['id'] ?? '';
        $maSP = $_GET['sp'] ?? '';

        if ($maBienThe == '') {
            die('Không tìm thấy mã biến thể.');
        }

        $bienThe = $this->bienTheModel->getById($maBienThe);

        if (!$bienThe) {
            die('Biến thể không tồn tại.');
        }

        if ($maSP == '') {
            $maSP = $bienThe['MaSP'];
        }

        try {
            $this->bienTheModel->delete($maBienThe);

            header('Location: index.php?controller=sanphambienthe&action=index&sp=' . urlencode($maSP));
            exit;
        } catch (PDOException $e) {
            die('Không thể xóa biến thể vì đang có dữ liệu liên quan.');
        }
    }
}