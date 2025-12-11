<?php
session_start();
require_once __DIR__ . '/../backend/models/User.php';

class AdminAuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit();
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // Key security check: verify password AND admin status
        if ($user && password_verify($password, $user['password_hash']) && $user['is_admin']) {
            $_SESSION['admin_user_id'] = $user['id'];
            $_SESSION['admin_user_name'] = $user['first_name'];
            header('Location: dashboard.php'); // Redirect to admin dashboard
        } else {
            // Provide a generic error message to prevent user enumeration
            header('Location: index.php?error=Invalid credentials or insufficient permissions.');
        }
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
    }
}


if (isset($_GET['action'])) {
    $controller = new AdminAuthController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "Action not found.";
    }
}
