<?php
session_start();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: /cart.php');
    exit();
}

// If user is not logged in, you might want to redirect them to login
// or implement a guest checkout flow. For now, we assume guest checkout.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="frontend/css/style.css">
    <link rel="stylesheet" href="frontend/css/checkout.css">
</head>
<body>
    <header>
        <!-- Consistent header -->
    </header>

    <main class="checkout-main">
        <h1>Checkout</h1>
        <div class="checkout-container">
            <form action="backend/controllers/OrderController.php?action=placeOrder" method="POST" class="checkout-form">
                <section class="shipping-address">
                    <h2>Shipping Address</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                     <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Street Address</label>
                        <input type="text" id="address" name="street_address" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="wilaya">Wilaya</label>
                            <input type="text" id="wilaya" name="wilaya" required>
                        </div>
                         <div class="form-group">
                            <label for="commune">Commune</label>
                            <input type="text" id="commune" name="commune" required>
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code" required>
                        </div>
                    </div>
                </section>

                <section class="payment-method">
                    <h2>Payment Method</h2>
                    <div class="payment-option">
                        <input type="radio" id="cod" name="payment_method" value="cod" checked data-qr-code="false">
                        <label for="cod">Cash on Delivery (COD)</label>
                    </div>
                    <div class="payment-option">
                        <input type="radio" id="baridimob" name="payment_method" value="baridimob" data-qr-code="true">
                        <label for="baridimob">BaridiMob</label>
                    </div>
                    <div class="payment-option">
                        <input type="radio" id="edahabia" name="payment_method" value="edahabia" data-qr-code="true">
                        <label for="edahabia">Edahabia</label>
                    </div>
                     <div class="payment-option">
                        <input type="radio" id="cib" name="payment_method" value="cib" data-qr-code="true">
                        <label for="cib">CIB</label>
                    </div>
                </section>

                <div id="qr-code-display" class="qr-code-container" style="display: none;">
                    <h3>Scan to complete payment</h3>
                    <img src="assets/images/mock-qr-code.svg" alt="Mock QR Code for Payment">
                    <p>After scanning, your order will be confirmed automatically.</p>
                </div>

                <button type="submit" class="place-order-btn">Place Order</button>
            </form>
        </div>
    </main>

    <footer>
        <!-- Consistent footer -->
    </footer>
    <script src="frontend/js/checkout.js"></script>
</body>
</html>
