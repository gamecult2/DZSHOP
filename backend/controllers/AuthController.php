<?php
session_start();

require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Or handle error appropriately
            header('Location: /register.php');
            exit();
        }

        $user = new User();
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->email = $_POST['email'];
        // Basic validation
        if (empty($user->first_name) || empty($user->last_name) || !filter_var($user->email, FILTER_VALIDATE_EMAIL) || empty($_POST['password'])) {
             // Handle validation error
            header('Location: /register.php?error=invalid_input');
            exit();
        }

        // Check if user exists
        if ($user->findByEmail($user->email)) {
            header('Location: /register.php?error=email_exists');
            exit();
        }

        $user->password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

        if ($user->create()) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->first_name;
            header('Location: /index.php'); // Redirect to homepage on success
        } else {
            header('Location: /register.php?error=creation_failed');
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login.php');
            exit();
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
            header('Location: /login.php?error=invalid_input');
            exit();
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            header('Location: /index.php'); // Redirect to homepage
        } else {
            header('Location: /login.php?error=invalid_credentials');
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /index.php');
    }
}


// Simple router to handle actions
if (isset($_GET['action'])) {
    $controller = new AuthController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        // Handle 404 or invalid action
        http_response_code(404);
        echo "Action not found.";
    }
}
