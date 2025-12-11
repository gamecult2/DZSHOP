<?php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    header('Location: index.php');
    exit();
}
require_once __DIR__ . '/../backend/models/User.php';
$userModel = new User();
$users = $userModel->findAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/admin_table.css">
</head>
<body>
    <header class="admin-header">
        <h1>User Management</h1>
        <nav class="admin-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="auth.php?action=logout">Logout</a>
        </nav>
    </header>

    <main class="admin-main">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="5">No users found.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
