<?php

class DashboardController
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        include __DIR__ . '/../Views/dashboard/index.php';
    }
}
