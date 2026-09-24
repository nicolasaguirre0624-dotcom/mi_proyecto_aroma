<h1>Listado Ciudad</h1>

<table border="2" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
           
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ciudades as $ciudad): ?>
        <tr>
            <td><?= htmlspecialchars($ciudad['id']) ?></td>
            <td><?= htmlspecialchars($ciudad['nombre']) ?></td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>