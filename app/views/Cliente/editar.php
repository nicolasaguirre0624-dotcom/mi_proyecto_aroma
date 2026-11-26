<?php
if (!defined('APP_BASE_PATH') || !isset($cliente) || !is_array($cliente) || isset($cliente['error'])) {
    http_response_code(404);
    exit();
}
?>
<h1>Editar cliente #<?= (int) $cliente['id'] ?></h1>
<form action="<?= APP_BASE_PATH ?>/clientes?action=actualizar" method="POST">
    <input type="hidden" name="id" value="<?= (int) $cliente['id'] ?>">
    <p>
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" required value="<?= htmlspecialchars($cliente['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="documento">Documento</label>
        <input id="documento" name="documento" type="text" required value="<?= htmlspecialchars($cliente['documento'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="correo">Correo</label>
        <input id="correo" name="correo" type="email" value="<?= htmlspecialchars($cliente['correo'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="telefono">Teléfono</label>
        <input id="telefono" name="telefono" type="text" value="<?= htmlspecialchars($cliente['telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <button type="submit">Actualizar cliente</button>
    <a href="<?= APP_BASE_PATH ?>/clientes">Cancelar</a>
</form>
