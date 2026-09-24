<h1>Listado de tipos de producto</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
    </tr>
    <?php foreach ($tiposProducto as $tipoProducto): ?>
        <tr>
            <td><?= htmlspecialchars($tipoProducto['idTipoProducto']) ?></td>
            <td><?= htmlspecialchars($tipoProducto['nTipoProducto']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
