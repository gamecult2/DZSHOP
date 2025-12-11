-- E-Commerce Platform Schema
-- For a Vanilla PHP Project
-- Database: MySQL

-- Users Table: Stores user account information.
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NULL,
  `is_admin` BOOLEAN NOT NULL DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Addresses Table: Stores user shipping addresses.
CREATE TABLE `addresses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `wilaya` VARCHAR(100) NOT NULL,
  `daira` VARCHAR(100) NOT NULL,
  `commune` VARCHAR(100) NOT NULL,
  `postal_code` VARCHAR(10) NOT NULL,
  `street_address` VARCHAR(255) NOT NULL,
  `is_default` BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- Categories Table: Stores product categories with i18n names.
CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `parent_id` INT NULL,
  `name_en` VARCHAR(255) NOT NULL,
  `name_fr` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) UNIQUE NOT NULL,
  `icon_url` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`parent_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
);

-- Brands Table: Stores product brands.
CREATE TABLE `brands` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) UNIQUE NOT NULL,
  `logo_url` VARCHAR(255) NULL
);

-- Products Table: The core product catalog with i18n fields.
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `brand_id` INT NULL,
  `sku` VARCHAR(100) UNIQUE NOT NULL,
  `name_en` VARCHAR(255) NOT NULL,
  `name_fr` VARCHAR(255) NOT NULL,
  `description_en` TEXT NOT NULL,
  `description_fr` TEXT NOT NULL,
  `specs_en` TEXT NULL,
  `specs_fr` TEXT NULL,
  `price` DECIMAL(12, 2) NOT NULL,
  `stock_quantity` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`brand_id`) REFERENCES `brands`(`id`) ON DELETE SET NULL
);

-- Product_Images Table: Stores multiple images for each product.
CREATE TABLE `product_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `alt_text_en` VARCHAR(255) NULL,
  `alt_text_fr` VARCHAR(255) NULL,
  `is_primary` BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
);

-- Orders Table: Stores customer orders.
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL, -- NULL for guest checkouts
  `status` ENUM('pending_payment', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded') NOT NULL DEFAULT 'pending_payment',
  `total_amount` DECIMAL(12, 2) NOT NULL,
  `shipping_address_details` TEXT NOT NULL, -- A denormalized snapshot of the address
  `payment_method` ENUM('cod', 'baridimob', 'edahabia', 'cib', 'bank_transfer') NOT NULL,
  `payment_status` ENUM('pending', 'paid', 'failed') NOT NULL DEFAULT 'pending',
  `transaction_id` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

-- Order_Items Table: Stores the individual products within an order.
CREATE TABLE `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price_at_purchase` DECIMAL(12, 2) NOT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE RESTRICT
);
