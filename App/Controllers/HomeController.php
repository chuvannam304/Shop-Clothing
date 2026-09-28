<?php

require_once __DIR__ . '/../Models/SanPham.php';

class HomeController
{
    private $sanPhamModel;

    public function __construct()
    {
        $this->sanPhamModel = new SanPham();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $title = 'Trang chủ';

        $sanPhams = $this->sanPhamModel->getHomeProducts();

        require __DIR__ . '/../Views/home/index.php';
    }
}