<h1>Listado Categorías</h1>

<table border="2" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categorias as $categoria): ?>
        <tr>
            <td><?= htmlspecialchars($categoria['id']) ?></td>
            <td><?= htmlspecialchars($categoria['nombre']) ?></td>
            <td><?= htmlspecialchars($categoria['descripcion']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>