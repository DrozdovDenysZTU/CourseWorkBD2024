<?php
require_once __DIR__ . '/../models/StatsModel.php';

class StatsController
{
    private $basePath = '/public';

    private function redirectTo($path)
    {
        header("Location: {$this->basePath}{$path}");
        exit;
    }

    public function index()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] != 'admin') {
            $this->redirectTo('login');
        }

        $statsModel = new StatsModel();

        $avgRatings = $statsModel->getAvgRatingPerProduct();
        $topProducts = $statsModel->getTopSellingProducts();
        $topUsers = $statsModel->getTopUsersByReviews();

        include(__DIR__ . '/../views/admin/statistics.php');
    }
}
