<?php

require_once __DIR__ . '/../config/Database.php';

class Product {
    private $conn;
    private $table = 'products';

    public $id;
    public $category_id;
    public $brand_id;
    public $sku;
    public $name_en;
    public $name_fr;
    // ... other properties

    public function __construct() {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    public function findById($id) {
        $query = "SELECT p.*, c.name_en as category_name_en, b.name as brand_name
                  FROM {$this->table} p
                  LEFT JOIN categories c ON p.category_id = c.id
                  LEFT JOIN brands b ON p.brand_id = b.id
                  WHERE p.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll() {
        $query = "SELECT p.*, c.name_en as category_name_en, b.name as brand_name
                  FROM {$this->table} p
                  LEFT JOIN categories c ON p.category_id = c.id
                  LEFT JOIN brands b ON p.brand_id = b.id
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByCategory($categoryId) {
        $query = "SELECT p.*, c.name_en as category_name_en, b.name as brand_name
                  FROM {$this->table} p
                  LEFT JOIN categories c ON p.category_id = c.id
                  LEFT JOIN brands b ON p.brand_id = b.id
                  WHERE p.category_id = :category_id
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (name_en, name_fr, sku, price, stock_quantity, category_id, description_en, description_fr)
                  VALUES (:name_en, :name_fr, :sku, :price, :stock_quantity, :category_id, :description_en, :description_fr)";
        $stmt = $this->conn->prepare($query);
        // Bind params from data array
        $stmt->bindParam(':name_en', $data['name_en']);
        $stmt->bindParam(':name_fr', $data['name_fr']);
        $stmt->bindParam(':sku', $data['sku']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock_quantity', $data['stock_quantity']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':description_en', $data['description_en']);
        $stmt->bindParam(':description_fr', $data['description_fr']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET
                    name_en = :name_en, name_fr = :name_fr, sku = :sku, price = :price,
                    stock_quantity = :stock_quantity, category_id = :category_id,
                    description_en = :description_en, description_fr = :description_fr
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name_en', $data['name_en']);
        $stmt->bindParam(':name_fr', $data['name_fr']);
        $stmt->bindParam(':sku', $data['sku']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock_quantity', $data['stock_quantity']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':description_en', $data['description_en']);
        $stmt->bindParam(':description_fr', $data['description_fr']);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
