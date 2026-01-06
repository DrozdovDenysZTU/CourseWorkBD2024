<?php
class CategoryModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM Categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Categories WHERE CategoryID = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function addCategory($name, $description) {
        $stmt = $this->db->prepare("INSERT INTO Categories (CategoryName, Description) VALUES (:name, :description)");
        return $stmt->execute([':name' => $name, ':description' => $description]);
    }
    
    public function updateCategory($id, $name, $description) {
        $stmt = $this->db->prepare("UPDATE Categories SET CategoryName = :name, Description = :description WHERE CategoryID = :id");
        return $stmt->execute([':id' => $id, ':name' => $name, ':description' => $description]);
    }
    
    public function deleteCategory($id) {
        $stmt = $this->db->prepare("DELETE FROM Categories WHERE CategoryID = :id");
        return $stmt->execute([':id' => $id]);
    }
}