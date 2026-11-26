<h1>Listado de Productos</h1>
<?php if (!empty($mensaje)): ?>
    <script>alert(<?= json_encode($mensaje, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>);</script>
    <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<h2>Crear producto</h2>
<form action="<?= APP_BASE_PATH ?>/productos?action=crear" method="POST">
    <label>Nombre <input name="nombre" type="text" required></label>
    <label>Precio <input name="precio" type="number" min="0" step="0.01" required></label>
    <label>Stock <input name="stock" type="number" min="0" step="1" required></label>
    <label>ID del proveedor <input name="id_proveedor" type="number" min="1" required></label>
    <label>ID de la categoría <input name="id_categoria" type="number" min="1" required></label>
    <button type="submit">Crear producto</button>
</form>
<table>
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
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?= (int) $producto['id'] ?></td>
                <td><?= htmlspecialchars($producto['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($producto['precio'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($producto['stock'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($producto['nombre_proveedor'] ?? 'Sin proveedor', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($producto['nombre_categoria'] ?? 'Sin categoría', ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <a href="<?= APP_BASE_PATH ?>/productos?action=editar&amp;id=<?= (int) $producto['id'] ?>">Editar</a>
                    <form action="<?= APP_BASE_PATH ?>/productos?action=eliminar" method="POST" style="display:inline-block">
                        <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$productos): ?>
            <tr><td colspan="7">No hay productos para mostrar.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
