<?php
session_start();
// If the admin is already logged in, redirect to the dashboard
if (isset($_SESSION['admin_user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Panel Login</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error-message"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>
        <form action="auth.php?action=login" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>
