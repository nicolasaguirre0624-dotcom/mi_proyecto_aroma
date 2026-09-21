<?php
require_once __DIR__ . '/../app/Controllers/ProductoController.php';

$controlador = new ProductoController();
$productos = $controlador->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda de Aromas - Catálogo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f9f9f9; }
        h1 { color: #333; text-align: center; }
        table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <h1>Catálogo de Perfumes - Aroma</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
        </tr>
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $row): ?>
                <tr>
                    <td><?php echo $row['idproducto']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td>$<?php echo $row['precio']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No hay productos registrados.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>