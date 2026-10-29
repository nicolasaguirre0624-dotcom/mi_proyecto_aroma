<?php
session_start();

require_once __DIR__ . '/../config/Database.php';

$conexion = (new Database())->connect();
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (empty($_SESSION['token_gestion_productos'])) {
    $_SESSION['token_gestion_productos'] = bin2hex(random_bytes(32));
}

$token = $_SESSION['token_gestion_productos'];
$mensaje = '';
$producto = null;
$productos = [];
$action = $_GET['action'] ?? '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tokenEnviado = $_POST['token'] ?? '';
        if (!is_string($tokenEnviado) || !hash_equals($token, $tokenEnviado)) {
            $mensaje = 'No se pudo completar la operación. Recarga la página e intenta de nuevo.';
        } else {
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

            if ($id === false || $id === null || $id < 1) {
                $mensaje = 'No se pudo completar la operación: el producto no es válido.';
            } elseif (($_POST['action'] ?? '') === 'eliminar') {
                $consulta = $conexion->prepare('DELETE FROM productos WHERE id = :id');
                $consulta->execute([':id' => $id]);
                $mensaje = $consulta->rowCount() > 0
                    ? 'Producto eliminado correctamente.'
                    : 'No se pudo eliminar el producto.';
            } elseif (($_POST['action'] ?? '') === 'actualizar') {
                $nombre = trim($_POST['nombre'] ?? '');
                $precio = $_POST['precio'] ?? '';
                $stock = filter_var($_POST['stock'] ?? null, FILTER_VALIDATE_INT);
                $idProveedor = filter_var($_POST['id_proveedor'] ?? null, FILTER_VALIDATE_INT);
                $idCategoria = filter_var($_POST['id_categoria'] ?? null, FILTER_VALIDATE_INT);

                if (
                    $nombre === ''
                    || !is_numeric($precio)
                    || (float) $precio < 0
                    || $stock === false || $stock === null || $stock < 0
                    || $idProveedor === false || $idProveedor === null || $idProveedor < 1
                    || $idCategoria === false || $idCategoria === null || $idCategoria < 1
                ) {
                    $mensaje = 'No se pudo actualizar el producto. Verifica los datos ingresados.';
                } else {
                    $existe = $conexion->prepare('SELECT 1 FROM productos WHERE id = :id');
                    $existe->execute([':id' => $id]);

                    if (!$existe->fetchColumn()) {
                        $mensaje = 'No se pudo actualizar el producto porque no existe.';
                    } else {
                        $consulta = $conexion->prepare(
                            'UPDATE productos
                             SET nombre = :nombre,
                                 precio = :precio,
                                 stock = :stock,
                                 id_proveedor = :id_proveedor,
                                 id_categoria = :id_categoria
                             WHERE id = :id'
                        );
                        $consulta->execute([
                            ':nombre' => $nombre,
                            ':precio' => $precio,
                            ':stock' => $stock,
                            ':id_proveedor' => $idProveedor,
                            ':id_categoria' => $idCategoria,
                            ':id' => $id
                        ]);
                        $mensaje = 'Producto actualizado correctamente.';
                    }
                }
            }
        }
    } elseif ($action === 'editar') {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if ($id !== false && $id !== null && $id > 0) {
            $consulta = $conexion->prepare('SELECT * FROM productos WHERE id = :id');
            $consulta->execute([':id' => $id]);
            $producto = $consulta->fetch(PDO::FETCH_ASSOC);
        }

        if (!$producto) {
            $mensaje = 'No se encontró el producto.';
        }
    }

    $consulta = $conexion->query(
        'SELECT p.id, p.nombre, p.precio, p.stock, p.id_proveedor, p.id_categoria,
                pr.nombre AS nombre_proveedor, c.nombre AS nombre_categoria
         FROM productos p
         LEFT JOIN proveedor pr ON p.id_proveedor = pr.id
         LEFT JOIN categorias c ON p.id_categoria = c.id
         ORDER BY p.id'
    );
    $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('Error al gestionar productos: ' . $e->getMessage());
    $mensaje = 'Ocurrió un error de base de datos. No se pudo completar la operación.';
}

function escapar($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de productos</title>
</head>
<body>
    <h1>Gestión de productos</h1>
    <?php if ($mensaje !== ''): ?>
        <script>alert(<?= json_encode($mensaje, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>);</script>
        <p><?= escapar($mensaje) ?></p>
    <?php endif; ?>

    <?php if ($producto): ?>
        <h2>Editar producto #<?= (int) $producto['id'] ?></h2>
        <form action="gestionar_productos.php" method="POST">
            <input type="hidden" name="token" value="<?= escapar($token) ?>">
            <input type="hidden" name="action" value="actualizar">
            <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">

            <p>
                <label for="nombre">Nombre</label>
                <input id="nombre" name="nombre" type="text" required value="<?= escapar($producto['nombre']) ?>">
            </p>
            <p>
                <label for="precio">Precio</label>
                <input id="precio" name="precio" type="number" min="0" step="0.01" required value="<?= escapar($producto['precio']) ?>">
            </p>
            <p>
                <label for="stock">Stock</label>
                <input id="stock" name="stock" type="number" min="0" step="1" required value="<?= escapar($producto['stock']) ?>">
            </p>
            <p>
                <label for="id_proveedor">ID del proveedor</label>
                <input id="id_proveedor" name="id_proveedor" type="number" min="1" required value="<?= escapar($producto['id_proveedor']) ?>">
            </p>
            <p>
                <label for="id_categoria">ID de la categoría</label>
                <input id="id_categoria" name="id_categoria" type="number" min="1" required value="<?= escapar($producto['id_categoria']) ?>">
            </p>

            <button type="submit">Actualizar producto</button>
            <a href="gestionar_productos.php">Cancelar</a>
        </form>
    <?php else: ?>
        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Proveedor</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $item): ?>
                    <tr>
                        <td><?= (int) $item['id'] ?></td>
                        <td><?= escapar($item['nombre']) ?></td>
                        <td><?= escapar($item['precio']) ?></td>
                        <td><?= escapar($item['stock']) ?></td>
                        <td><?= escapar($item['nombre_proveedor'] ?? 'Sin proveedor') ?></td>
                        <td><?= escapar($item['nombre_categoria'] ?? 'Sin categoría') ?></td>
                        <td>
                            <a href="gestionar_productos.php?action=editar&amp;id=<?= (int) $item['id'] ?>">Editar</a>
                            <form action="gestionar_productos.php" method="POST" style="display:inline">
                                <input type="hidden" name="token" value="<?= escapar($token) ?>">
                                <input type="hidden" name="action" value="eliminar">
                                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$productos): ?>
                    <tr><td colspan="7">No hay productos para mostrar.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
