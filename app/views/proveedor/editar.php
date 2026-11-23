<h1>Editar proveedor #<?= (int) $proveedor['id'] ?></h1>
<form action="<?= APP_BASE_PATH ?>/proveedores?action=actualizar" method="POST">
    <input type="hidden" name="id" value="<?= (int) $proveedor['id'] ?>">
    <p>
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" required value="<?= htmlspecialchars($proveedor['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="direccion">Dirección</label>
        <input id="direccion" name="direccion" type="text" value="<?= htmlspecialchars($proveedor['direccion'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="telefono">Teléfono</label>
        <input id="telefono" name="telefono" type="text" value="<?= htmlspecialchars($proveedor['telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="correo">Correo</label>
        <input id="correo" name="correo" type="email" value="<?= htmlspecialchars($proveedor['correo'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <button type="submit">Actualizar proveedor</button>
    <a href="<?= APP_BASE_PATH ?>/proveedores">Cancelar</a>
</form>
