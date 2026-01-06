<?php
class CartModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getCartItems($userId)
    {
        $stmt = $this->db->prepare(
            "SELECT c.CartID, c.ProductID, c.Quantity, p.ProductName, p.Price, p.ImageURL
             FROM Cart c 
             JOIN Products p ON c.ProductID = p.ProductID 
             WHERE c.UserID = :userId"
        );
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($userId, $productId, $quantity = 1)
    {
        $stmt = $this->db->prepare(
            "SELECT CartID, Quantity FROM Cart WHERE UserID = :userId AND ProductID = :productId"
        );
        $stmt->execute([':userId' => $userId, ':productId' => $productId]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $newQuantity = $existing['Quantity'] + $quantity;
            $stmt = $this->db->prepare(
                "UPDATE Cart SET Quantity = :quantity WHERE CartID = :cartId"
            );
            return $stmt->execute([':quantity' => $newQuantity, ':cartId' => $existing['CartID']]);
        } else {
            $stmt = $this->db->prepare(
                "INSERT INTO Cart (UserID, ProductID, Quantity) VALUES (:userId, :productId, :quantity)"
            );
            return $stmt->execute([':userId' => $userId, ':productId' => $productId, ':quantity' => $quantity]);
        }
    }

    public function updateCartItem($cartId, $quantity)
    {
        $quantity = max(1, (int)$quantity);
        $stmt = $this->db->prepare(
            "UPDATE Cart SET Quantity = :quantity WHERE CartID = :cartId"
        );
        return $stmt->execute([':quantity' => $quantity, ':cartId' => $cartId]);
    }

    public function removeFromCart($cartId)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM Cart WHERE CartID = :cartId"
        );
        return $stmt->execute([':cartId' => $cartId]);
    }

    public function clearCart($userId)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM Cart WHERE UserID = :userId"
        );
        return $stmt->execute([':userId' => $userId]);
    }

    public function getCartItemByUserAndProduct($userId, $productId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM Cart WHERE UserID = :userId AND ProductID = :productId"
        );
        $stmt->execute([':userId' => $userId, ':productId' => $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCartItemById($cartId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM Cart WHERE CartID = :cartId"
        );
        $stmt->execute([':cartId' => $cartId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
