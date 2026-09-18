<?php

$controller = $_GET['controller'] ?? 'admin';
$action = $_GET['action'] ?? 'dashboard';

switch ($controller) {

    // ADMIN 
    case 'admin':
        require_once __DIR__ . '/../App/Controllers/AdminController.php';
        $controllerObject = new AdminController();

        switch ($action) {
            case 'dashboard':
                $controllerObject->dashboard();
                break;

            default:
                echo 'Action Admin không tồn tại';
                break;
        }

        break;

    // SẢN PHẨM
    case 'sanpham':
        require_once __DIR__ . '/../App/Controllers/SanPhamController.php';
        $controllerObject = new SanPhamController();

        switch ($action) {
            case 'index':
                $controllerObject->index();
                break;

            case 'create':
                $controllerObject->create();
                break;

            case 'store':
                $controllerObject->store();
                break;

            case 'edit':
                $controllerObject->edit();
                break;

            case 'update':
                $controllerObject->update();
                break;

            case 'delete':
                $controllerObject->delete();
                break;

            default:
                echo 'Action Sản phẩm không tồn tại';
                break;
        }

        break;

    // LOẠI 

    case 'loai':
        require_once __DIR__ . '/../App/Controllers/LoaiController.php';
        $controllerObject = new LoaiController();

        switch ($action) {
            case 'index':
                $controllerObject->index();
                break;

            case 'create':
                $controllerObject->create();
                break;

            case 'store':
                $controllerObject->store();
                break;

            case 'edit':
                $controllerObject->edit();
                break;

            case 'update':
                $controllerObject->update();
                break;

            case 'delete':
                $controllerObject->delete();
                break;

            default:
                echo 'Action Danh mục không tồn tại';
                break;
        }

        break;

    // NHÃN HIỆU

    case 'nhanhieu':
        require_once __DIR__ . '/../App/Controllers/NhanHieuController.php';
        $controllerObject = new NhanHieuController();

        switch ($action) {
            case 'index':
                $controllerObject->index();
                break;

            case 'create':
                $controllerObject->create();
                break;

            case 'store':
                $controllerObject->store();
                break;

            case 'edit':
                $controllerObject->edit();
                break;

            case 'update':
                $controllerObject->update();
                break;

            case 'delete':
                $controllerObject->delete();
                break;

            default:
                echo 'Action Nhãn hiệu không tồn tại';
                break;
        }

        break;

    // =========================
    // MÀU SẮC
    // =========================
    case 'mausac':
        require_once __DIR__ . '/../App/Controllers/MauSacController.php';
        $controllerObject = new MauSacController();

        switch ($action) {
            case 'index':
                $controllerObject->index();
                break;

            case 'create':
                $controllerObject->create();
                break;

            case 'store':
                $controllerObject->store();
                break;

            case 'edit':
                $controllerObject->edit();
                break;

            case 'update':
                $controllerObject->update();
                break;

            case 'delete':
                $controllerObject->delete();
                break;

            default:
                echo 'Action Màu sắc không tồn tại';
                break;
        }

        break;

    // =========================
    // SIZE
    // =========================
    case 'size':
        require_once __DIR__ . '/../App/Controllers/SizeController.php';
        $controllerObject = new SizeController();

        switch ($action) {
            case 'index':
                $controllerObject->index();
                break;

            case 'create':
                $controllerObject->create();
                break;

            case 'store':
                $controllerObject->store();
                break;

            case 'edit':
                $controllerObject->edit();
                break;

            case 'update':
                $controllerObject->update();
                break;

            case 'delete':
                $controllerObject->delete();
                break;

            default:
                echo 'Action Size không tồn tại';
                break;
        }

        break;

    // =========================
    // BIẾN THỂ SẢN PHẨM
    // =========================
    case 'sanphambienthe':
        require_once __DIR__ . '/../App/Controllers/SanPhamBienTheController.php';
        $controllerObject = new SanPhamBienTheController();

        switch ($action) {
            case 'index':
                $controllerObject->index();
                break;

            case 'create':
                $controllerObject->create();
                break;

            case 'store':
                $controllerObject->store();
                break;

            case 'edit':
                $controllerObject->edit();
                break;

            case 'update':
                $controllerObject->update();
                break;

            case 'delete':
                $controllerObject->delete();
                break;

            default:
                echo 'Action Biến thể sản phẩm không tồn tại';
                break;
        }

        break;

    // =========================
    // HÌNH ẢNH SẢN PHẨM
    // =========================
    case 'hinhanhsanpham':
        require_once __DIR__ . '/../App/Controllers/HinhAnhSanPhamController.php';
        $controllerObject = new HinhAnhSanPhamController();

        switch ($action) {
            case 'index':
                $controllerObject->index();
                break;

            case 'create':
                $controllerObject->create();
                break;

            case 'store':
                $controllerObject->store();
                break;

            case 'edit':
                $controllerObject->edit();
                break;

            case 'update':
                $controllerObject->update();
                break;

            case 'delete':
                $controllerObject->delete();
                break;

            default:
                echo 'Action Hình ảnh sản phẩm không tồn tại';
                break;
        }

        break;

    // =========================
    // KHÔNG TỒN TẠI
    // =========================
    default:
        echo 'Controller không tồn tại';
        break;
}