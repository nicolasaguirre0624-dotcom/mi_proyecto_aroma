<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    public function index() {
        $producto = new Producto();
        return $producto->listar();
    }
}
?>