<?php
require_once __DIR__ . '/config.php';

class Database {
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $localConfigPath = __DIR__ . '/database.local.php';
            $localConfig = is_file($localConfigPath) ? require $localConfigPath : [];
            if (!is_array($localConfig)) {
                throw new RuntimeException('Local database configuration must return an array.');
            }

            $host = getenv('DB_HOST') ?: ($localConfig['host'] ?? 'localhost');
            $dbname = getenv('DB_NAME') ?: ($localConfig['name'] ?? 'lost_found_db');
            $username = getenv('DB_USER') ?: ($localConfig['username'] ?? 'root');
            $password = getenv('DB_PASSWORD');
            $password = $password === false ? ($localConfig['password'] ?? '') : $password;

            $this->conn = new PDO(
                "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
            $this->conn->exec("SET time_zone = '+08:00'");
        } catch(Throwable $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            echo 'Database connection failed. Check the database settings and server error log.';
        }
        return $this->conn;
    }
}
