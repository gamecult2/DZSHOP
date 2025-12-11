<?php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../backend/models/Product.php';
$productModel = new Product();
$products = $productModel->findAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/admin_table.css">
</head>
<body>
    <header class="admin-header">
        <h1>Product Management</h1>
        <nav class="admin-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="auth.php?action=logout">Logout</a>
        </nav>
    </header>

    <main class="admin-main">
        <div class="toolbar">
            <a href="edit_product.php" class="add-btn">Add New Product</a>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name (EN)</th>
                    <th>Category</th>
                    <th>Price (DZD)</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['sku']) ?></td>
                        <td><?= htmlspecialchars($product['name_en']) ?></td>
                        <td><?= htmlspecialchars($product['category_name_en']) ?></td>
                        <td><?= number_format($product['price'], 2) ?></td>
                        <td><?= htmlspecialchars($product['stock_quantity']) ?></td>
                        <td class="actions">
                            <a href="edit_product.php?id=<?= $product['id'] ?>" class="edit-btn">Edit</a>
                            <a href="delete_product.php?id=<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
