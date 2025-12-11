<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="frontend/css/style.css">
    <link rel="stylesheet" href="frontend/css/product.css">
</head>
<body>
    <header>
        <!-- Same header as index.php -->
    </header>

    <main class="product-main">
        <div class="product-image-gallery">
            <img src="assets/images/placeholder-product.svg" alt="Main Product Image" class="main-image">
            <div class="thumbnail-images">
                <img src="assets/images/placeholder-product.svg" alt="Product Thumbnail" class="thumbnail">
                <img src="assets/images/placeholder-product.svg" alt="Product Thumbnail" class="thumbnail">
            </div>
        </div>

        <div class="product-details">
            <h1>Product Name</h1>
            <p class="product-brand">Brand: <strong>BrandName</strong></p>
            <p class="product-price">34,999 DZD</p>
            <div class="product-actions">
                <form action="backend/controllers/CartController.php?action=add" method="POST">
                    <input type="hidden" name="product_id" value="1"> <!-- Assuming a product with ID 1 exists -->
                    <input type="number" value="1" min="1" class="quantity-input" name="quantity">
                    <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                </form>
            </div>
            <div class="product-description">
                <h2>Description</h2>
                <p>This is a detailed description of the product. It highlights all the key features, benefits, and specifications to help the customer make an informed decision.</p>
            </div>
            <div class="product-specs">
                <h2>Technical Specifications</h2>
                <ul>
                    <li><strong>Spec 1:</strong> Value</li>
                    <li><strong>Spec 2:</strong> Value</li>
                    <li><strong>Spec 3:</strong> Value</li>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <!-- Same footer as index.php -->
    </footer>
</body>
</html>
