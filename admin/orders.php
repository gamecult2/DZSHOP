<?php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../backend/models/Order.php';
require_once __DIR__ . '/../backend/models/Order.php';
$orderModel = new Order();
$orders = $orderModel->findAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/admin_table.css">
</head>
<body>
    <header class="admin-header">
        <h1>Order Management</h1>
        <nav class="admin-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="auth.php?action=logout">Logout</a>
        </nav>
    </header>

    <main class="admin-main">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer (User ID)</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7">No orders found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['id']) ?></td>
                            <td><?= htmlspecialchars($order['user_id'] ?? 'Guest') ?></td>
                            <td><?= number_format($order['total_amount'], 2) ?> DZD</td>
                            <td><?= htmlspecialchars($order['status']) ?></td>
                            <td><?= htmlspecialchars($order['payment_method']) ?></td>
                            <td><?= htmlspecialchars($order['created_at']) ?></td>
                            <td class="actions">
                                <a href="view_order.php?id=<?= $order['id'] ?>" class="edit-btn">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
