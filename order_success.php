<?php
$order_id = isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
    <link rel="stylesheet" href="frontend/css/style.css">
    <style>
        .success-main {
            text-align: center;
            padding: 50px 20px;
        }
        .success-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #28a745;
            font-size: 2.5rem;
        }
        p {
            font-size: 1.2rem;
            margin: 15px 0;
        }
        .order-id {
            font-weight: bold;
            font-size: 1.3rem;
            color: #333;
        }
        .continue-shopping-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #e4393c;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <!-- Consistent header -->
    </header>

    <main class="success-main">
        <div class="success-container">
            <h1>Thank You!</h1>
            <p>Your order has been placed successfully.</p>
            <p>Your Order ID is: <span class="order-id"><?= $order_id ?></span></p>
            <a href="index.php" class="continue-shopping-btn">Continue Shopping</a>
        </div>
    </main>

    <footer>
        <!-- Consistent footer -->
    </footer>
</body>
</html>
