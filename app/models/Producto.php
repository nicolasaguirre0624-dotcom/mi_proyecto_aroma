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
            $sql = "SELECT p.idProducto,
                           p.nombreProducto,
                           p.precioProducto,
                           p.stock,
                           p.fechaVenc,
                           m.nombreMarca,
                           tp.nTipoProduct,
                           dc.valorComprada
                    FROM productos p
                    LEFT JOIN marcas m ON p.idMarca = m.idMarca
                    LEFT JOIN tipoproducto tp ON p.idTipoProduct = tp.idTipoProduct
                    LEFT JOIN descripcompra dc ON p.idProducto = dc.idProducto
                    ORDER BY p.idProducto";

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
            $sql = "SELECT p.idProducto,
                           p.nombreProducto,
                           p.precioProducto,
                           p.stock,
                           p.fechaVenc,
                           m.nombreMarca,
                           tp.nTipoProduct,
                           dc.valorComprada
                    FROM productos p
                    LEFT JOIN marcas m ON p.idMarca = m.idMarca
                    LEFT JOIN tipoproducto tp ON p.idTipoProduct = tp.idTipoProduct
                    LEFT JOIN descripcompra dc ON p.idProducto = dc.idProducto
                    WHERE p.idProducto = :id";

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
}