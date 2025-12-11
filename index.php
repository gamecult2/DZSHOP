<?php
session_start();
require_once 'backend/services/Localization.php';
Localization::load();
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Site</title>
    <link rel="stylesheet" href="frontend/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="/">ELECTRONICS</a>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="<?= Localization::get('search_placeholder') ?>">
            </div>
            <div class="nav-links">
                <a href="/account"><?= Localization::get('account') ?></a>
                <a href="/cart"><?= Localization::get('cart') ?></a>
                <div class="language-switcher">
                    <a href="?lang=en" class="<?= ($_SESSION['lang'] ?? 'en') === 'en' ? 'active' : '' ?>">EN</a> |
                    <a href="?lang=fr" class="<?= ($_SESSION['lang'] ?? 'en') === 'fr' ? 'active' : '' ?>">FR</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <aside class="sidebar">
            <ul class="category-list">
                <li><a href="/category/electronics">Electronics</a></li>
                <li><a href="/category/pc-components">PC Components</a></li>
                <li><a href="/category/gaming">Gaming</a></li>
                <li><a href="/category/home-appliances">Home Appliances</a></li>
                <li><a href="/category/accessories">Accessories</a></li>
                <li><a href="/category/smartphones">Smartphones</a></li>
                <li><a href="/category/networking">Networking</a></li>
                <li><a href="/category/audio">Audio</a></li>
                <li><a href="/category/gadgets">Gadgets</a></li>
            </ul>
        </aside>

        <section class="main-content">
            <div class="hero-carousel">
                <!-- Carousel content goes here -->
                <img src="assets/images/placeholder-banner.svg" alt="Promotional Banner" style="width:100%;">
            </div>

            <section class="product-grid-section">
                <h2>Best Sellers</h2>
                <div class="product-grid">
                    <!-- Product items will be dynamically loaded here -->
                    <div class="product-card">
                        <img src="assets/images/placeholder-product.svg" alt="Product Name">
                        <h3>Product Name</h3>
                        <p class="price">19,999 DZD</p>
                    </div>
                     <div class="product-card">
                        <img src="assets/images/placeholder-product.svg" alt="Product Name">
                        <h3>Product Name</h3>
                        <p class="price">24,999 DZD</p>
                    </div>
                     <div class="product-card">
                        <img src="assets/images/placeholder-product.svg" alt="Product Name">
                        <h3>Product Name</h3>
                        <p class="price">29,999 DZD</p>
                    </div>
                </div>
            </section>
        </section>
    </main>

    <footer>
        <div class="footer-links">
            <a href="/about">About Us</a>
            <a href="/contact">Contact</a>
            <a href="/shipping">Shipping Policy</a>
            <a href="/returns">Returns</a>
        </div>
        <p>&copy; 2024 E-Commerce Site. All rights reserved.</p>
    </footer>

    <script src="frontend/js/main.js"></script>
</body>
</html>
