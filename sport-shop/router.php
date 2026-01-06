<?php
session_start();

require_once __DIR__ . '/models/Database.php';
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/OrderController.php';
require_once __DIR__ . '/controllers/ReviewController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ProfileController.php';
require_once __DIR__ . '/controllers/StatsController.php';

$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = rtrim($scriptName, '/');
$requestUri = $_SERVER['REQUEST_URI'];

$request = substr($requestUri, strlen($basePath));
$request = $request ?: '/';
$request = explode('?', $request)[0];

if (preg_match('/\.(css|js|jpg|jpeg|png|gif|svg|ico|woff2?|ttf)$/i', $request)) {
    return false;
}

$method = $_SERVER['REQUEST_METHOD'];
switch (true) {

    case $request === '/' && $method === 'GET':
        (new HomeController())->home();
        break;

    case $request === '/products' && $method === 'GET':
        (new ProductController())->index();
        break;

    case preg_match('|^/product/detail/(\d+)$|', $request, $matches) && $method === 'GET':
        (new ProductController())->detail($matches[1]);
        break;

    case $request === '/categories' && $method === 'GET':
        (new CategoryController())->index();
        break;

    case $request === '/cart' && $method === 'GET':
        (new CartController())->index();
        break;

    case $request === '/cart/add' && $method === 'POST':
        (new CartController())->add();
        break;

    case $request === '/cart/update' && $method === 'POST':
        (new CartController())->update();
        break;

    case preg_match('|^/cart/remove/(\d+)$|', $request, $matches) && $method === 'GET':
        (new CartController())->remove($matches[1]);
        break;

    case $request === '/cart/clear' && $method === 'GET':
        (new CartController())->clear();
        break;

    case $request === '/cart/checkout' && $method === 'GET':
        (new CartController())->checkout();
        break;

    case $request === '/order/history' && $method === 'GET':
        (new OrderController())->history();
        break;

    case preg_match('|^/order/detail/(\d+)$|', $request, $matches) && $method === 'GET':
        (new OrderController())->detail($matches[1]);
        break;

    case preg_match('|^/admin/orders/detail/(\d+)$|', $request, $matches) && $method === 'GET':
        (new OrderController())->detail($matches[1]);
        break;

    case $request === '/review/add' && $method === 'POST':
        (new ReviewController())->add();
        break;

    case $request === '/login':
        if ($method === 'GET') {
            (new AuthController())->login();
        } elseif ($method === 'POST') {
            (new AuthController())->login();
        }
        break;

    case $request === '/register':
        if ($method === 'GET') {
            (new AuthController())->register();
        } elseif ($method === 'POST') {
            (new AuthController())->register();
        }
        break;

    case $request === '/logout' && $method === 'GET':
        (new AuthController())->logout();
        break;

    case $request === '/admin/products' && $method === 'GET':
        (new AdminController())->products();
        break;

    case $request === '/admin/categories' && $method === 'GET':
        (new AdminController())->manageCategories();
        break;

    case $request === '/admin/categories/save' && $method === 'POST':
        (new AdminController())->saveCategory();
        break;

    case $request === '/admin/categories/delete' && $method === 'POST':
        (new AdminController())->deleteCategory();
        break;

    case $request === '/admin/orders':
        if ($method === 'GET') {
            (new OrderController())->manage();
        } elseif ($method === 'POST') {
            (new OrderController())->updateStatus();
        }
        break;

    case $request === '/admin/reviews' && $method === 'GET':
        (new ReviewController())->manage();
        break;

    case $request === '/admin/reviews/approve' && $method === 'POST':
        if (isset($_POST['id'])) {
            (new ReviewController())->approve($_POST['id']);
        } else {
            header("Location: " . base_url('admin/reviews'));
            exit;
        }
        break;

    case $request === '/admin/reviews/reject' && $method === 'POST':
        if (isset($_POST['id'])) {
            (new ReviewController())->reject($_POST['id']);
        } else {
            header("Location: " . base_url('admin/reviews'));
            exit;
        }
        break;

    case $request === '/admin/reviews/delete' && $method === 'POST':
        if (isset($_POST['id'])) {
            (new ReviewController())->delete($_POST['id']);
        } else {
            header("Location: " . base_url('admin/reviews'));
            exit;
        }
        break;

    case $request === '/admin/products/save' && $method === 'POST':
        (new AdminController())->saveProduct();
        break;

    case $request === '/admin/products/delete' && $method === 'POST':
        (new AdminController())->delete();
        break;

    case $request === '/profile' && $method === 'GET':
        (new ProfileController())->index();
        break;

    case $request === '/admin/statistics' && $method === 'GET':
        (new StatsController())->index();
        break;

    default:
        (new HomeController())->notFound();
        break;
}
