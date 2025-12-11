<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="frontend/css/style.css">
    <link rel="stylesheet" href="frontend/css/auth.css">
</head>
<body>
    <header>
        <!-- Consistent header -->
    </header>

    <main class="auth-main">
        <div class="auth-container">
            <h2>Create an Account</h2>
            <form action="backend/controllers/AuthController.php?action=register" method="POST">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="auth-btn">Register</button>
            </form>
            <p class="auth-switch">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </main>

    <footer>
        <!-- Consistent footer -->
    </footer>
</body>
</html>
