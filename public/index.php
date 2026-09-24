<?php

require_once __DIR__ . '/../app/controllers/ProductoController.php';
require_once __DIR__ . '/../app/controllers/ClientesController.php';
require_once __DIR__ . '/../app/controllers/ProveedorController.php';
require_once __DIR__ . '/../app/controllers/CiudadController.php';


$productoController = new ProductoController();
$clientesController = new ClientesController();
$proveedorController = new ProveedorController();
$ciudadController = new CiudadController();


$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Aroma</title>
</head>

<body>

    <h1>Aroma</h1>

    <a href="/aroma/public/productos">Productos</a>
    <a href="/aroma/public/clientes">Clientes</a>
    <a href="/aroma/public/proveedores">Proveedores</a>
    <a href="/aroma/public/ciudades">Ciudades</a>
    
    <?php

    if ($method == 'GET' && $uri == '/aroma/public/productos') {

        $productoController->index();

    }


    if ($method == 'GET' && $uri == '/aroma/public/clientes') {

        $clientesController->index();

    }


    if ($method == 'GET' && $uri == '/aroma/public/proveedores') {

        $proveedorController->index();

    }


    if ($method == 'GET' && $uri == '/aroma/public/ciudades') {

        $ciudadController->index();

    }


    ?>

</body>

</html>