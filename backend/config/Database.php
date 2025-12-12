<?php

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $config_file = __DIR__ . '/config.php';
        if (!file_exists($config_file)) {
            die("Configuration file not found. Please run the installer.");
        }

        $config = require $config_file;

        $host = $config['DB_HOST'];
        $db_name = $config['DB_NAME'];
        $username = $config['DB_USER'];
        $password = $config['DB_PASS'];

        try {
            $this->conn = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // In a real app, you should log this error, not echo it.
            die('Connection Error: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
