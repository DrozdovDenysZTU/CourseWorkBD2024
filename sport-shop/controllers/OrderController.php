<?php
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController
{
    public function history()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: login");
            exit;
        }

        $orderModel = new OrderModel();
        $userId = $_SESSION['user']['UserID'];
        $orders = $orderModel->getOrdersByUser($userId);

        include(__DIR__ . '/../views/order/history.php');
    }

   public function detail($id)
{
    if (!isset($_SESSION['user'])) {
        header("Location: login");
        exit;
    }

    $orderModel = new OrderModel();
    $order = $orderModel->getOrderHeader($id); 
    $orderItems = $orderModel->getOrderDetails($id);

    if (empty($order)) {
        header("Location: order/history");
        exit;
    }

    $currentStatus = $_GET['status'] ?? '';
    $currentPage = $_GET['page'] ?? 1;

    $orderId = $id;  

    if ($_SESSION['user']['Role'] === 'admin') {
        include(__DIR__ . '/../views/order/order_detail.php');
    } else {
        include(__DIR__ . '/../views/cart/checkout.php');
    }
}

    public function manage()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] != 'admin') {
            header("Location: login");
            exit;
        }

        $orderModel = new OrderModel();

        $statusFilter = $_GET['status'] ?? '';
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $itemsPerPage = 10;

        $totalOrders = $orderModel->countOrders($statusFilter);
        $totalPages = ceil($totalOrders / $itemsPerPage);

        $orders = $orderModel->getOrdersPaged($statusFilter, $itemsPerPage, $currentPage);

        include(__DIR__ . '/../views/admin/orders.php');
    }

    public function updateStatus()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] != 'admin') {
            header("Location: " . base_url('login'));
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'] ?? null;
            $status = $_POST['status'] ?? null;
            $statusFilter = $_POST['current_status_filter'] ?? '';
            $page = $_POST['current_page'] ?? 1;

            if ($orderId && $status) {
                $orderModel = new OrderModel();
                $orderModel->updateOrderStatus($orderId, $status);

                $_SESSION['message'] = "Статус замовлення №$orderId оновлено на \"$status\"";
            }

            $query = '';
            $params = [];
            if ($statusFilter !== '') {
                $params['status'] = $statusFilter;
            }
            if ($page > 1) {
                $params['page'] = $page;
            }
            if (!empty($params)) {
                $query = '?' . http_build_query($params);
            }

            header("Location: " . base_url('admin/orders') . $query);
            exit();
        }
    }

    private function buildQueryString(): string
    {
        $query = [];
        if (!empty($_GET['status'])) {
            $query['status'] = $_GET['status'];
        }
        if (!empty($_GET['page'])) {
            $query['page'] = $_GET['page'];
        }
        return $query ? '?' . http_build_query($query) : '';
    }
}
