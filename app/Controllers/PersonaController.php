<?php
require_once __DIR__ . '/../models/Persona.php';
require_once __DIR__ . '/../../config/Database.php';

class PersonaController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection('tienda_aroma');
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $correo = trim($_POST['correo'] ?? '');

            if ($nombre !== '' && $correo !== '') {
                $sql = 'INSERT INTO personas (nombre, correo) VALUES (:nombre, :correo)';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':correo' => $correo
                ]);
            }
        }

        header('Location: index.php');
        exit;
    }

    public function listar() {
        $sql = 'SELECT * FROM personas ORDER BY id DESC';
        $stmt = $this->conn->query($sql);
        return $stmt ? $stmt->fetchAll() : [];
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $sql = 'DELETE FROM personas WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
        }

        header('Location: index.php');
        exit;
    }
}

if (isset($_GET['action'])) {
    $controller = new PersonaController();

    switch ($_GET['action']) {
        case 'guardar':
            $controller->guardar();
            break;
        case 'eliminar':
            $controller->eliminar();
            break;
    }
}
