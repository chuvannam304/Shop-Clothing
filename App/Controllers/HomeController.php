<?php

class HomeController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $title = 'Trang chủ';

        require __DIR__ . '/../Views/home/index.php';
    }
}