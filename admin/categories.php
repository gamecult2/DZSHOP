<?php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    header('Location: index.php');
    exit();
}
// For now, this is a placeholder. We will need to create a Category model and controller.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/admin_table.css">
</head>
<body>
    <header class="admin-header">
        <h1>Category Management</h1>
        <nav class="admin-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="auth.php?action=logout">Logout</a>
        </nav>
    </header>

    <main class="admin-main">
        <div class="toolbar">
            <a href="edit_category.php" class="add-btn">Add New Category</a>
        </div>

        <p>Category management functionality will be implemented here.</p>
        <!-- Category table will be dynamically generated here -->
    </main>
</body>
</html>
