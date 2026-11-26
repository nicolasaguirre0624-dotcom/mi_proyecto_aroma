<?php
require_once __DIR__ . "/../../config/Database.php";

class Compra {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function getAll() {
        $sql = "SELECT c.idCompra, c.int_proveedor, c.fechaCompra, c.idTipoPago,
                       c.ivaCompra, c.valorCompra, p.nombre AS nombre_proveedor
                FROM compra c
                LEFT JOIN proveedor p ON c.int_proveedor = p.id
                ORDER BY c.idCompra";
        $consulta = $this->connection->query($sql);
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $consulta = $this->connection->prepare(
            "SELECT idCompra, int_proveedor, fechaCompra, idTipoPago, ivaCompra, valorCompra
             FROM compra
             WHERE idCompra = :id"
        );
        $consulta->execute([':id' => $id]);
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($idProveedor, $fechaCompra, $idTipoPago, $ivaCompra, $valorCompra) {
        try {
            $consulta = $this->connection->prepare(
                "INSERT INTO compra (int_proveedor, fechaCompra, idTipoPago, ivaCompra, valorCompra)
                 VALUES (:id_proveedor, :fecha_compra, :id_tipo_pago, :iva, :valor)"
            );
            return $consulta->execute([
                ':id_proveedor' => $idProveedor,
                ':fecha_compra' => $fechaCompra,
                ':id_tipo_pago' => $idTipoPago,
                ':iva' => $ivaCompra,
                ':valor' => $valorCompra
            ]);
        } catch (PDOException $e) {
            error_log('Error al crear compra: ' . $e->getMessage());
            return false;
        }
    }

    public function actualizar($id, $idProveedor, $fechaCompra, $idTipoPago, $ivaCompra, $valorCompra) {
        try {
            $consulta = $this->connection->prepare(
                "UPDATE compra
                 SET int_proveedor = :id_proveedor,
                     fechaCompra = :fecha_compra,
                     idTipoPago = :id_tipo_pago,
                     ivaCompra = :iva,
                     valorCompra = :valor
                 WHERE idCompra = :id"
            );
            $consulta->execute([
                ':id_proveedor' => $idProveedor,
                ':fecha_compra' => $fechaCompra,
                ':id_tipo_pago' => $idTipoPago,
                ':iva' => $ivaCompra,
                ':valor' => $valorCompra,
                ':id' => $id
            ]);
            return $consulta->rowCount() > 0 || $this->getById($id) !== false;
        } catch (PDOException $e) {
            error_log('Error al actualizar compra: ' . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $consulta = $this->connection->prepare("DELETE FROM compra WHERE idCompra = :id");
            $consulta->execute([':id' => $id]);
            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error al eliminar compra: ' . $e->getMessage());
            return false;
        }
    }
}
