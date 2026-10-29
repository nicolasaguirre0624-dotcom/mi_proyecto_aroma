<?php

require_once __DIR__ . "/../../config/Database.php";

class Producto {

    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function getAll() {
        try {
            $sql = "SELECT p.id,
                           p.nombre,
                           p.precio,
                           p.stock,
                           p.id_proveedor,
                           p.id_categoria,
                           pr.nombre AS nombre_proveedor,
                           c.nombre AS nombre_categoria
                    FROM productos p
                    LEFT JOIN proveedor pr ON p.id_proveedor = pr.id
                    LEFT JOIN categorias c ON p.id_categoria = c.id
                    ORDER BY p.id";

            $consulta = $this->connection->query($sql);
            return $consulta->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [
                "error" => "Hubo un error en la consulta de la tabla productos: " . $e->getMessage()
            ];
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT p.id,
                           p.nombre,
                           p.precio,
                           p.stock,
                           p.id_proveedor,
                           p.id_categoria,
                           pr.nombre AS nombre_proveedor,
                           c.nombre AS nombre_categoria
                    FROM productos p
                    LEFT JOIN proveedor pr ON p.id_proveedor = pr.id
                    LEFT JOIN categorias c ON p.id_categoria = c.id
                    WHERE p.id = :id";

            $consulta = $this->connection->prepare($sql);
            $consulta->bindParam(':id', $id, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [
                "error" => "Hubo un error al consultar el producto: " . $e->getMessage()
            ];
        }
    }

    // Obtener un producto por su ID (para el formulario de edición)
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar producto en la base de datos
    public function actualizarProducto($id, $nombre, $precio, $stock, $idProveedor, $idCategoria) {
        try {
            $existe = $this->connection->prepare("SELECT 1 FROM productos WHERE id = :id");
            $existe->execute([':id' => $id]);
            if (!$existe->fetchColumn()) {
                return false;
            }

            $sql = "UPDATE productos
                    SET nombre = :nombre,
                        precio = :precio,
                        stock = :stock,
                        id_proveedor = :id_proveedor,
                        id_categoria = :id_categoria
                    WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':precio' => $precio,
                ':stock' => $stock,
                ':id_proveedor' => $idProveedor,
                ':id_categoria' => $idCategoria,
                ':id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            error_log('Error al actualizar producto: ' . $e->getMessage());
            return false;
        }
    }

    // Eliminar producto de forma segura (Cumple con el taller)
    public function eliminarProducto($id) {
        try {
            $sql = "DELETE FROM productos WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error al eliminar producto: ' . $e->getMessage());
            return false;
        }
    }
}