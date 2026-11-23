<h1>Listado Ciudad</h1>
<?php if (!empty($mensaje)): ?>
    <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<h2>Crear ciudad</h2>
<form action="<?= APP_BASE_PATH ?>/ciudades?action=crear" method="POST">
    <label>Nombre <input name="nombre" type="text" required></label>
    <button type="submit">Crear ciudad</button>
</form>
<table border="2" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ciudades as $ciudad): ?>
        <tr>
            <td><?= htmlspecialchars($ciudad['id']) ?></td>
            <td><?= htmlspecialchars($ciudad['nombre']) ?></td>
            <td>
                <a href="<?= APP_BASE_PATH ?>/ciudades?action=editar&amp;id=<?= (int) $ciudad['id'] ?>">Editar</a>
                <form action="<?= APP_BASE_PATH ?>/ciudades?action=eliminar" method="POST" style="display:inline-block">
                    <input type="hidden" name="id" value="<?= (int) $ciudad['id'] ?>">
                    <button type="submit" onclick="return confirm('¿Eliminar esta ciudad?')">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>