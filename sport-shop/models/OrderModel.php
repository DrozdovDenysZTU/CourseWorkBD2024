<?php
class OrderModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createOrder($userId, $totalAmount, $items)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("INSERT INTO Orders (UserID, OrderDate, TotalAmount, Status) 
                                       VALUES (:userId, CURDATE(), :total, 'Pending')");
            $stmt->execute([':userId' => $userId, ':total' => $totalAmount]);
            $orderId = $this->db->lastInsertId();

            foreach ($items as $item) {
                $stmt = $this->db->prepare("INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Price) 
                                           VALUES (:orderId, :productId, :quantity, :price)");
                $stmt->execute([
                    ':orderId' => $orderId,
                    ':productId' => $item['ProductID'],
                    ':quantity' => $item['Quantity'],
                    ':price' => $item['Price']
                ]);
            }

            $stmt = $this->db->prepare("DELETE FROM Cart WHERE UserID = :userId");
            $stmt->execute([':userId' => $userId]);

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getOrdersByUser($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM Orders WHERE UserID = :userId ORDER BY OrderDate DESC");
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($orderId)
    {
        $stmt = $this->db->prepare("SELECT od.*, p.ProductName, p.ImageURL 
                               FROM OrderDetails od 
                               JOIN Products p ON od.ProductID = p.ProductID 
                               WHERE od.OrderID = :orderId");
        $stmt->execute([':orderId' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders()
    {
        $stmt = $this->db->query("SELECT o.*, u.Username FROM Orders o JOIN Users u ON o.UserID = u.UserID ORDER BY o.OrderDate DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countOrders($status = '')
    {
        if ($status) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM Orders WHERE Status = :status");
            $stmt->execute([':status' => $status]);
        } else {
            $stmt = $this->db->query("SELECT COUNT(*) FROM Orders");
        }
        return (int)$stmt->fetchColumn();
    }

    public function getOrdersPaged($status = '', $limit = 10, $page = 1)
    {
        $offset = ($page - 1) * $limit;

        if ($status) {
            $stmt = $this->db->prepare("SELECT o.*, u.Username 
                                       FROM Orders o 
                                       JOIN Users u ON o.UserID = u.UserID 
                                       WHERE o.Status = :status 
                                       ORDER BY o.OrderDate DESC 
                                       LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("SELECT o.*, u.Username 
                                       FROM Orders o 
                                       JOIN Users u ON o.UserID = u.UserID 
                                       ORDER BY o.OrderDate DESC 
                                       LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("UPDATE Orders SET Status = :status WHERE OrderID = :orderId");
        return $stmt->execute([':status' => $status, ':orderId' => $orderId]);
    }

    public function getOrderHeader($orderId)
    {
        $stmt = $this->db->prepare("
        SELECT o.*, u.Username 
        FROM Orders o 
        JOIN Users u ON o.UserID = u.UserID 
        WHERE o.OrderID = :orderId
    ");
        $stmt->execute([':orderId' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
