<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class HomeController
{
    public function index()
    {
        $this->home();
    }

    public function home()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $featuredProducts = $productModel->getProductsByPriceRange(1000, 5000, 'DESC');
        $categories = $categoryModel->getAllCategories();

        include(view_path('views/includes/header.php'));
        include(view_path('views/includes/navbar.php'));
        include(view_path('views/home/index.php'));
        include(view_path('views/includes/footer.php'));
    }

    public function notFound()
    {
        include(view_path('views/404.php'));
        exit;
    }
}
