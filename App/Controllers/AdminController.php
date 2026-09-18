<?php

class AdminController
{
    public function dashboard()
    {
        $title = 'Dashboard';

        $activeMenu = 'dashboard';

        $view = __DIR__ . '/../Views/admin/dashboard.php';

        require __DIR__ . '/../Views/layouts/admin.php';
    }
}