<?php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../backend/models/Product.php';
// In a real app, you'd also load categories and brands to populate select dropdowns.
$productModel = new Product();
$product = null;
$is_edit_mode = false;

if (isset($_GET['id'])) {
    $is_edit_mode = true;
    $product = $productModel->findById((int)$_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_edit_mode ? 'Edit' : 'Add' ?> Product</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/admin_form.css">
</head>
<body>
    <header class="admin-header">
        <h1><?= $is_edit_mode ? 'Edit' : 'Add' ?> Product</h1>
        <nav class="admin-nav"><a href="products.php">Back to Products</a></nav>
    </header>

    <main class="admin-main">
        <form action="product_actions.php?action=<?= $is_edit_mode ? 'update' : 'create' ?>" method="POST" class="data-form">
            <?php if ($is_edit_mode): ?>
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="name_en">Product Name (EN)</label>
                <input type="text" id="name_en" name="name_en" value="<?= htmlspecialchars($product['name_en'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="name_fr">Product Name (FR)</label>
                <input type="text" id="name_fr" name="name_fr" value="<?= htmlspecialchars($product['name_fr'] ?? '') ?>" required>
            </div>
             <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="sku" value="<?= htmlspecialchars($product['sku'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price (DZD)</label>
                <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($product['price'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity'] ?? '0') ?>" required>
            </div>
             <div class="form-group">
                <label for="category_id">Category ID</label>
                <input type="number" id="category_id" name="category_id" value="<?= htmlspecialchars($product['category_id'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="description_en">Description (EN)</label>
                <textarea id="description_en" name="description_en" rows="5" required><?= htmlspecialchars($product['description_en'] ?? '') ?></textarea>
            </div>
             <div class="form-group">
                <label for="description_fr">Description (FR)</label>
                <textarea id="description_fr" name="description_fr" rows="5" required><?= htmlspecialchars($product['description_fr'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="submit-btn"><?= $is_edit_mode ? 'Update' : 'Create' ?> Product</button>
        </form>
    </main>
</body>
</html>
