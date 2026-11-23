<?php

$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('APP_BASE_PATH', $basePath);

require_once __DIR__ . '/../app/controllers/ProductoController.php';
require_once __DIR__ . '/../app/controllers/ClientesController.php';
require_once __DIR__ . '/../app/controllers/ProveedorController.php';
require_once __DIR__ . '/../app/controllers/CiudadController.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_once __DIR__ . '/../app/controllers/TipoProductoController.php';


$controllers = [
    '/productos' => new ProductoController(),
    '/clientes' => new ClientesController(),
    '/proveedores' => new ProveedorController(),
    '/ciudades' => new CiudadController(),
    '/categorias' => new CategoriaController(),
    '/tipos-producto' => new TipoProductoController()
];


$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = is_string($uri) ? $uri : '/';
if (
    $basePath !== ''
    && ($uri === $basePath || str_starts_with($uri, $basePath . '/'))
) {
    $uri = substr($uri, strlen($basePath)) ?: '/';
}
$action = $_GET['action'] ?? '';

if (isset($controllers[$uri])) {
    $controller = $controllers[$uri];
    if ($method === 'POST' && in_array($action, ['crear', 'actualizar', 'eliminar'], true)) {
        $controller->$action();
    }
    if ($method === 'GET' && $action === 'editar') {
        $controller->editar();
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Aroma</title>
</head>

<body>

    <h1>Aroma</h1>

    <a href="<?= APP_BASE_PATH ?>/productos">Productos</a>
    <a href="<?= APP_BASE_PATH ?>/clientes">Clientes</a>
    <a href="<?= APP_BASE_PATH ?>/proveedores">Proveedores</a>
    <a href="<?= APP_BASE_PATH ?>/ciudades">Ciudades</a>
    <a href="<?= APP_BASE_PATH ?>/categorias">Categorías</a>
    <a href="<?= APP_BASE_PATH ?>/tipos-producto">Tipos de producto</a>

    <?php

    if ($method === 'GET' && isset($controllers[$uri])) {
        $controllers[$uri]->index();
    }


    ?>

</body>

</html>