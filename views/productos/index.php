<?php
require_once __DIR__ . '/../../Controllers/ProductoController.php';
$controller = new ProductoController();
$productos = $controller->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos - Aroma</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <script src="../../public/js/main.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Catálogo de Perfumes - Aroma</h1>
        <div class="table-wrap">
            <table>
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
                                <td><?= $prod['idproducto'] ?? $prod['id'] ?? ''; ?></td>
                                <td><?= $prod['nombre'] ?? ''; ?></td>
                                <td><?= $prod['precio'] ?? ''; ?></td>
                                <td><?= $prod['stock'] ?? ''; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="empty-state">No hay productos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>