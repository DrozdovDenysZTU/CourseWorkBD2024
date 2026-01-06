<?php
class AdminController
{
    public function products()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['Role'] ?? '') !== 'admin') {
            header("Location: " . BASE_URL);
            exit;
        }

        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            $id = $_POST['id'] ?? null;

            if ($action == 'add') {
                $data = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'stock' => $_POST['stock'],
                    'category' => $_POST['category'],
                    'image' => $_POST['image']
                ];
                $productModel->addProduct($data);
            } elseif ($action == 'edit' && $id) {
                $data = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'stock' => $_POST['stock'],
                    'category' => $_POST['category'],
                    'image' => $_POST['image']
                ];
                $productModel->updateProduct($id, $data);
            } elseif ($action == 'delete' && $id) {
                $productModel->deleteProduct($id);
            }

            header("Location: " . BASE_URL . "admin/products");
            exit;
        }


        $products = $productModel->getAllProducts();
        $categories = $categoryModel->getAllCategories();

        include(__DIR__ . '/../views/admin/products.php');
    }

    public function saveProduct()
    {
        $productModel = new ProductModel();

        $action = $_POST['action'];
        $id = $_POST['id'] ?? null;

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'category' => $_POST['category'],
            'image' => $_POST['image'], 
        ];

        if ($action === 'add') {
            $productModel->addProduct($data);
            $_SESSION['message'] = "Товар успішно додано.";
        } elseif ($action === 'edit' && $id) {
            $productModel->updateProduct($id, $data);
            $_SESSION['message'] = "Товар оновлено.";
        }

        header("Location: " . base_url('admin/products'));
        exit;
    }


    public function delete()
    {
        if (isset($_POST['id'])) {
            $productModel = new ProductModel();
            $productModel->deleteProduct($_POST['id']);
            $_SESSION['message'] = "Товар успішно видалено.";
        }

        header("Location: " . base_url('admin/products'));
        exit;
    }

    public function manageCategories()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['Role'] ?? '') !== 'admin') {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        include(__DIR__ . '/../views/admin/categories.php');
    }

    public function saveCategory()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['Role'] ?? '') !== 'admin') {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        $categoryModel = new CategoryModel();

        $action = $_POST['action'] ?? '';
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($action === 'add') {
            $categoryModel->addCategory($name, $description);
            $_SESSION['message'] = "Категорію успішно додано.";
        } elseif ($action === 'edit' && $id) {
            $categoryModel->updateCategory($id, $name, $description);
            $_SESSION['message'] = "Категорію успішно оновлено.";
        }

        header("Location: " . base_url('admin/categories'));
        exit;
    }

    public function deleteCategory()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['Role'] ?? '') !== 'admin') {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        if (isset($_POST['id'])) {
            $categoryModel = new CategoryModel();
            $categoryModel->deleteCategory($_POST['id']);
            $_SESSION['message'] = "Категорію успішно видалено.";
        }

        header("Location: " . base_url('admin/categories'));
        exit;
    }
}
