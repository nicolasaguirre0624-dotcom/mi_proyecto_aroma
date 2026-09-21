<?php
require_once __DIR__ . '/../../Controllers/ProductoController.php';
$controller = new ProductoController();
$productos = $controller->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos - Aroma</title>
</head>
<body>
    <h1>Catálogo de Perfumes - Aroma</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $prod): ?>
                    <tr>
                        <td><?= $prod['id']; ?></td>
                        <td><?= $prod['nombre']; ?></td>
                        <td><?= $prod['precio']; ?></td>
                        <td><?= $prod['stock']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay productos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>