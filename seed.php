<?php
// A simple script to seed the database with a product for testing.
require_once 'backend/config/Database.php';

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    // Create a category first
    $conn->exec("INSERT INTO categories (id, name_en, name_fr, slug) VALUES (1, 'Electronics', 'Électronique', 'electronics') ON DUPLICATE KEY UPDATE name_en=name_en;");

    // Insert a product
    $stmt = $conn->prepare(
        "INSERT INTO products (id, category_id, sku, name_en, name_fr, description_en, description_fr, price, stock_quantity)
         VALUES (1, 1, 'ELEC-001', 'Test Product', 'Produit de Test', 'Desc EN', 'Desc FR', 29999.00, 50)
         ON DUPLICATE KEY UPDATE name_en = VALUES(name_en);"
    );
    $stmt->execute();

    echo "Database seeded successfully with a test product.";

} catch (PDOException $e) {
    die("Database seeding failed: " . $e->getMessage());
}
