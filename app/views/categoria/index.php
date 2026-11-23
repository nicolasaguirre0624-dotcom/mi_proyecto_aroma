<h1>Listado Categorías</h1>
<?php if (!empty($mensaje)): ?>
    <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<h2>Crear categoría</h2>
<form action="<?= APP_BASE_PATH ?>/categorias?action=crear" method="POST">
    <label>Nombre <input name="nombre" type="text" required></label>
    <label>Descripción <textarea name="descripcion"></textarea></label>
    <button type="submit">Crear categoría</button>
</form>
<table border="2" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categorias as $categoria): ?>
        <tr>
            <td><?= htmlspecialchars($categoria['id']) ?></td>
            <td><?= htmlspecialchars($categoria['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($categoria['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            <td>
                <a href="<?= APP_BASE_PATH ?>/categorias?action=editar&amp;id=<?= (int) $categoria['id'] ?>">Editar</a>
                <form action="<?= APP_BASE_PATH ?>/categorias?action=eliminar" method="POST" style="display:inline-block">
                    <input type="hidden" name="id" value="<?= (int) $categoria['id'] ?>">
                    <button type="submit" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>