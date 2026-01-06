<?php
class ProductModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM Products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProductsByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE CategoryID = :categoryId");
        $stmt->execute([':categoryId' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE ProductID = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function searchProducts($searchTerm) {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE ProductName LIKE :search");
        $stmt->execute([':search' => "%$searchTerm%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProductsByPriceRange($min, $max, $order = 'ASC') {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE Price BETWEEN :min AND :max ORDER BY Price $order");
        $stmt->execute([':min' => $min, ':max' => $max]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addProduct($data) {
        $stmt = $this->db->prepare("INSERT INTO Products (ProductName, Description, Price, Stock, CategoryID, ImageURL) 
                                    VALUES (:name, :description, :price, :stock, :category, :image)");
        return $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':stock' => $data['stock'],
            ':category' => $data['category'],
            ':image' => $data['image']
        ]);
    }
    
    public function updateProduct($id, $data) {
        $stmt = $this->db->prepare("UPDATE Products SET 
                                    ProductName = :name, 
                                    Description = :description, 
                                    Price = :price, 
                                    Stock = :stock, 
                                    CategoryID = :category, 
                                    ImageURL = :image 
                                    WHERE ProductID = :id");
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':stock' => $data['stock'],
            ':category' => $data['category'],
            ':image' => $data['image']
        ]);
    }
    
    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM Products WHERE ProductID = :id");
        return $stmt->execute([':id' => $id]);
    }
}