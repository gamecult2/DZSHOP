<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Installation</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f7f6; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="password"], input[type="email"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { display: block; width: 100%; padding: 12px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 1.1rem; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .message { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .warning { background-color: #fff3cd; color: #856404; padding: 15px; border-radius: 4px; text-align: center; font-weight: bold;}
    </style>
</head>
<body>
    <div class="container">
        <h1>E-Commerce Website Installer</h1>
        <?php
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- Get Form Data ---
            $db_host = $_POST['db_host'];
            $db_name = $_POST['db_name'];
            $db_user = $_POST['db_user'];
            $db_pass = $_POST['db_pass'];

            $admin_email = $_POST['admin_email'];
            $admin_fname = $_POST['admin_fname'];
            $admin_lname = $_POST['admin_lname'];
            $admin_pass  = $_POST['admin_pass'];

            // --- 1. Test DB Connection ---
            try {
                $dbh = new PDO("mysql:host=$db_host", $db_user, $db_pass);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Create database if it doesn't exist
                $dbh->exec("CREATE DATABASE IF NOT EXISTS `$db_name`;");
                $dbh->exec("USE `$db_name`;");

            } catch (PDOException $e) {
                $errors[] = "Database Connection Failed: " . $e->getMessage();
            }

            // --- 2. Execute Schema ---
            if (empty($errors)) {
                try {
                    $sql = file_get_contents('database/schema.sql');
                    $dbh->exec($sql);
                } catch (Exception $e) {
                    $errors[] = "Failed to create database tables: " . $e->getMessage();
                }
            }

            // --- 3. Create Admin User ---
            if (empty($errors)) {
                try {
                    $password_hash = password_hash($admin_pass, PASSWORD_BCRYPT);
                    $stmt = $dbh->prepare(
                        "INSERT INTO users (email, password_hash, first_name, last_name, is_admin)
                         VALUES (:email, :password, :fname, :lname, 1)"
                    );
                    $stmt->execute([
                        ':email' => $admin_email,
                        ':password' => $password_hash,
                        ':fname' => $admin_fname,
                        ':lname' => $admin_lname
                    ]);
                } catch (Exception $e) {
                    $errors[] = "Failed to create admin user: " . $e->getMessage();
                }
            }

            // --- 4. Create Config File ---
            if (empty($errors)) {
                $config_content = "<?php\n\nreturn [\n    'DB_HOST' => '{$db_host}',\n    'DB_NAME' => '{$db_name}',\n    'DB_USER' => '{$db_user}',\n    'DB_PASS' => '{$db_pass}'\n];\n";
                if (!file_put_contents('backend/config/config.php', $config_content)) {
                     $errors[] = "Failed to write config file. Please check file permissions.";
                }
            }

            if (empty($errors)) {
                $success = true;
            }
        }
        ?>

        <?php if ($success): ?>
            <div class="message success">
                <strong>Installation Successful!</strong>
                <p>Your website is ready. You can now log in to the admin panel with the credentials you provided.</p>
            </div>
            <div class="warning">
                <strong>IMPORTANT:</strong> For security reasons, please delete the <strong>install.php</strong> file from your server immediately.
            </div>
        <?php elseif (!empty($errors)): ?>
             <div class="message error">
                <strong>Installation Failed:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="install.php" class="btn" style="text-align:center; text-decoration:none;">Try Again</a>
        <?php else: ?>
             <form action="install.php" method="POST">
                <h2>Database Configuration</h2>
                <div class="form-group">
                    <label for="db_host">Database Host</label>
                    <input type="text" id="db_host" name="db_host" value="localhost" required>
                </div>
                <div class="form-group">
                    <label for="db_name">Database Name</label>
                    <input type="text" id="db_name" name="db_name" required>
                </div>
                <div class="form-group">
                    <label for="db_user">Database Username</label>
                    <input type="text" id="db_user" name="db_user" required>
                </div>
                <div class="form-group">
                    <label for="db_pass">Database Password</label>
                    <input type="password" id="db_pass" name="db_pass">
                </div>

                <h2>Admin Account Creation</h2>
                <div class="form-group">
                    <label for="admin_email">Admin Email</label>
                    <input type="email" id="admin_email" name="admin_email" required>
                </div>
                 <div class="form-group">
                    <label for="admin_fname">First Name</label>
                    <input type="text" id="admin_fname" name="admin_fname" required>
                </div>
                <div class="form-group">
                    <label for="admin_lname">Last Name</label>
                    <input type="text" id="admin_lname" name="admin_lname" required>
                </div>
                <div class="form-group">
                    <label for="admin_pass">Admin Password</label>
                    <input type="password" id="admin_pass" name="admin_pass" required>
                </div>

                <button type="submit" class="btn">Install Now</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
