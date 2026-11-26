<h1>Listado de Proveedores</h1>
<?php if (!empty($mensaje)): ?>
    <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<h2>Crear proveedor</h2>
<form action="<?= APP_BASE_PATH ?>/proveedores?action=crear" method="POST">
    <label>Nombre <input name="nombre" type="text" required></label>
    <label>Dirección <input name="direccion" type="text"></label>
    <label>Teléfono <input name="telefono" type="text"></label>
    <label>Correo <input name="correo" type="email"></label>
    <button type="submit">Crear proveedor</button>
</form>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Dirección</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($proveedores as $proveedor): ?>
    <tr>
        <td><?= (int) $proveedor['id'] ?></td>
        <td><?= htmlspecialchars($proveedor['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($proveedor['telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($proveedor['correo'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($proveedor['direccion'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td>
            <a href="<?= APP_BASE_PATH ?>/proveedores?action=editar&amp;id=<?= (int) $proveedor['id'] ?>">Editar</a>
            <form action="<?= APP_BASE_PATH ?>/proveedores?action=eliminar" method="POST" style="display:inline-block">
                <input type="hidden" name="id" value="<?= (int) $proveedor['id'] ?>">
                <button type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>