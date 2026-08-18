<?php

require_once __DIR__ . '/../Models/Dashboard.php';
require_once __DIR__ . '/../Models/Reservation.php';

class DashboardController
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $stats = Dashboard::getStats((int) $_SESSION['user_id']);
        $featuredDestination = Dashboard::getFeaturedDestination();
        $recentReservations = array_slice(Reservation::getByUser((int) $_SESSION['user_id']), 0, 4);

        include __DIR__ . '/../Views/dashboard/index.php';
    }
}
