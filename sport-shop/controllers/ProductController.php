<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/ReviewModel.php';

class ProductController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $search = $_GET['search'] ?? null;
        $categoryId = $_GET['category_id'] ?? null;

        if ($search) {
            $products = $productModel->searchProducts($search);
            $title = "Результати пошуку: $search";
        } elseif ($categoryId) {
            $products = $productModel->getProductsByCategory($categoryId);
            $category = $categoryModel->getCategoryById($categoryId);
            $title = "Категорія: " . htmlspecialchars($category['CategoryName']);
        } else {
            $products = $productModel->getAllProducts();
            $title = "Всі товари";
        }

        $categories = $categoryModel->getAllCategories();
        include(__DIR__ . '/../views/product/index.php');
    }

    public function detail($id)
    {
        $productModel = new ProductModel();
        $reviewModel = new ReviewModel();

        $product = $productModel->getProductById($id);
        $reviews = $reviewModel->getReviewsByProduct($id);
        $averageRating = $reviewModel->getAverageRating($id);

        include(__DIR__ . '/../views/product/detail.php');
    }
}
