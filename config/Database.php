<?php

class Database {
    private $host = "localhost";
    private $db_name = "tienda_aroma";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection($dbName = null) {
        $this->conn = null;

        $databaseName = $dbName ?: $this->db_name;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $databaseName . ";charset=utf8",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
