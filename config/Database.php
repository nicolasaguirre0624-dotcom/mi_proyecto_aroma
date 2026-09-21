<?php
class Database {
    private $host;
    private $port;
    private $nombredb;
    private $user;
    private $password;
    private $connection;

    public function __construct() {
        $envPath = __DIR__ . "/../.env";

        if (file_exists($envPath)) {
            $env = parse_ini_file($envPath);
            $this->host = $env['DB_HOST'] ?? 'localhost';
            $this->port = $env['DB_PORT'] ?? 3306;
            $this->nombredb = $env['DB_NAME'] ?? '';
            $this->user = $env['DB_USER'] ?? 'root';
            $this->password = $env['DB_PASSWORD'] ?? '';
        } else {
            $this->host = 'localhost';
            $this->port = 3306;
            $this->nombredb = 'mi_proyecto_aroma';
            $this->user = 'root';
            $this->password = '';
        }
    }

    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->nombredb};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $this->connection;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
   