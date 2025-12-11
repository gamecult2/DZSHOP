<?php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    // Return a forbidden error if not logged in
    http_response_code(403);
    exit('Access Forbidden.');
}

require_once __DIR__ . '/../backend/models/Product.php';

class ProductActionsController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit('Invalid request.');

        $data = $this->sanitizePostData();
        if ($this->productModel->create($data)) {
            header('Location: products.php');
        } else {
            // Handle error
            exit('Failed to create product.');
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) exit('Invalid request.');

        $id = (int)$_POST['id'];
        $data = $this->sanitizePostData();
        if ($this->productModel->update($id, $data)) {
            header('Location: products.php');
        } else {
            // Handle error
            exit('Failed to update product.');
        }
    }

    public function delete() {
        if (!isset($_GET['id'])) exit('Invalid request.');

        $id = (int)$_GET['id'];
        if ($this->productModel->delete($id)) {
            header('Location: products.php');
        } else {
            // Handle error
            exit('Failed to delete product.');
        }
    }

    private function sanitizePostData() {
        $data = [];
        $fields = ['name_en', 'name_fr', 'sku', 'price', 'stock_quantity', 'category_id', 'description_en', 'description_fr'];
        foreach ($fields as $field) {
            $data[$field] = htmlspecialchars(strip_tags($_POST[$field]));
        }
        return $data;
    }
}

// Simple router
if (isset($_GET['action'])) {
    $controller = new ProductActionsController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "Action not found.";
    }
}
