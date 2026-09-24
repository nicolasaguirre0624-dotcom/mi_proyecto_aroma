<?php
require_once __DIR__ . "/../app/controllers/ProductoController.php";
require_once __DIR__ . '/../app/controllers/ClientesController.php';
require_once __DIR__ . '/../app/controllers/ProveedorController.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_once __DIR__ . '/../app/controllers/CiudadController.php';
require_once __DIR__ . '/../app/controllers/CompraController.php';

$productoController = new ProductoController();
$productoController->index();

$clienteController = new ClienteController();
$clienteController->index();

$proveedorController = new ProveedorController();
$proveedorController->index();

$categoriaController = new CategoriaController();
$categoriaController->index();

$ciudadController = new CiudadController();
$ciudadController->index();

$compraController = new CompraController();
$compraController->index();

