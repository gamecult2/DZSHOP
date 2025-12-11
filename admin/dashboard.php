<?php
session_start();
// Security check: ensure the user is logged in as an admin
if (!isset($_SESSION['admin_user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <header class="admin-header">
        <h1>Admin Dashboard</h1>
        <nav class="admin-nav">
            <span>Welcome, <?= htmlspecialchars($_SESSION['admin_user_name']) ?>!</span>
            <a href="products.php">Manage Products</a>
            <a href="orders.php">Manage Orders</a>
            <a href="auth.php?action=logout">Logout</a>
        </nav>
    </header>

    <main class="admin-main">
        <h2>Dashboard Overview</h2>
        <p>Welcome to the admin panel. From here you can manage products, orders, and site settings.</p>
        <!-- More dashboard widgets will go here -->
    </main>
</body>
</html>
