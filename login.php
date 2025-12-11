<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="frontend/css/style.css">
    <link rel="stylesheet" href="frontend/css/auth.css">
</head>
<body>
    <header>
        <!-- Consistent header -->
    </header>

    <main class="auth-main">
        <div class="auth-container">
            <h2>Login to Your Account</h2>
            <form action="backend/controllers/AuthController.php?action=login" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="auth-btn">Login</button>
            </form>
            <p class="auth-switch">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </main>

    <footer>
        <!-- Consistent footer -->
    </footer>
</body>
</html>
