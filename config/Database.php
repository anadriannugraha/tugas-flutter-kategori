<?php
/**
 * Database Singleton Class
 * Auto-detect environment: InfinityFree (production) vs localhost (development)
 */

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        // Deteksi environment secara otomatis
        $serverHost = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');
        $appEnv     = getenv('APP_ENV') ?: 'development';

        $isProduction = (
            stripos($serverHost, 'infinityfree') !== false ||
            stripos($serverHost, 'free.nf') !== false ||
            $appEnv === 'production'
        );

        if ($isProduction) {
            // InfinityFree Configuration
            $host     = 'sql303.infinityfree.com';
            $dbname   = 'if0_41961050_mydb';
            $username = 'if0_41961050';
            $password = 'dYQxArGykqF5s';
        } else {
            // Localhost Configuration
            $host     = '127.0.0.1';
            $dbname   = 'mydb';
            $username = 'root';
            $password = '';
        }

        try {
            $this->connection = new PDO(
                "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                $username,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch(PDOException $e) {
            die(json_encode([
                'error'       => 'Koneksi database gagal: ' . $e->getMessage(),
                'environment' => $isProduction ? 'production' : 'development'
            ], JSON_PRETTY_PRINT));
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
