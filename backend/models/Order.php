<?php

require_once __DIR__ . '/../config/Database.php';

class Order {
    private $conn;
    private $orders_table = 'orders';
    private $order_items_table = 'order_items';

    public function __construct() {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    public function create($data) {
        $this->conn->beginTransaction();

        try {
            // Insert into orders table
            $query = "INSERT INTO {$this->orders_table} (user_id, total_amount, shipping_address_details, payment_method)
                      VALUES (:user_id, :total_amount, :shipping_address_details, :payment_method)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':total_amount', $data['total_amount']);
            $stmt->bindParam(':shipping_address_details', $data['shipping_address_details']);
            $stmt->bindParam(':payment_method', $data['payment_method']);
            $stmt->execute();
            $orderId = $this->conn->lastInsertId();

            // Insert into order_items table
            foreach ($data['items'] as $item) {
                $itemQuery = "INSERT INTO {$this->order_items_table} (order_id, product_id, quantity, price_at_purchase)
                              VALUES (:order_id, :product_id, :quantity, :price_at_purchase)";
                $itemStmt = $this->conn->prepare($itemQuery);
                $itemStmt->bindParam(':order_id', $orderId);
                $itemStmt->bindParam(':product_id', $item['product_id']);
                $itemStmt->bindParam(':quantity', $item['quantity']);
                $itemStmt->bindParam(':price_at_purchase', $item['price']);
                $itemStmt->execute();
            }

            $this->conn->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->conn->rollBack();
            // In a real app, log this error
            return false;
        }
    }

    public function findByUserId($userId) {
        $query = "SELECT * FROM {$this->orders_table} WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAll() {
        $query = "SELECT * FROM {$this->orders_table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
