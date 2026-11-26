<h1>Listado de Clientes</h1>
<?php if (!empty($mensaje)): ?>
    <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<h2>Crear cliente</h2>
<form action="<?= APP_BASE_PATH ?>/clientes?action=crear" method="POST">
    <label>Nombre <input name="nombre" type="text" required></label>
    <label>Documento <input name="documento" type="text" required></label>
    <label>Correo <input name="correo" type="email"></label>
    <label>Teléfono <input name="telefono" type="text"></label>
    <button type="submit">Crear cliente</button>
</form>
<table border="2">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>documento</th>
        <th>Correo</th>
        <th>Telefono</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($clientes as $cliente): ?>
    <tr>
        <td><?= (int) $cliente['id'] ?></td>
        <td><?= htmlspecialchars($cliente['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($cliente['documento'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($cliente['correo'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($cliente['telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <td>
            <a href="<?= APP_BASE_PATH ?>/clientes?action=editar&amp;id=<?= (int) $cliente['id'] ?>">Editar</a>
            <form action="<?= APP_BASE_PATH ?>/clientes?action=eliminar" method="POST" style="display:inline-block">
                <input type="hidden" name="id" value="<?= (int) $cliente['id'] ?>">
                <button type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>