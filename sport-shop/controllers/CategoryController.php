<?php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        include(__DIR__ . '/../views/category/index.php');
    }

    public function manage()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] != 'admin') {
            header("Location: login");
            exit;
        }

        $categoryModel = new CategoryModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            $id = $_POST['id'] ?? null;

            if ($action == 'add') {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $categoryModel->addCategory($name, $description);
            } elseif ($action == 'edit' && $id) {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $categoryModel->updateCategory($id, $name, $description);
            } elseif ($action == 'delete' && $id) {
                $categoryModel->deleteCategory($id);
            }

            header("Location: admin/categories");
            exit;
        }

        $categories = $categoryModel->getAllCategories();
        include(__DIR__ . '/../views/admin/categories.php');
    }
}
