<h1>Listado de Proveedores</h1>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Dirección</th>
    </tr>
    <?php foreach ($proveedores as $proveedor): ?>
    <tr>
        <td><?= $proveedor['nombre'] ?></td>
        <td><?= $proveedor['telefono'] ?></td>
        <td><?= $proveedor['correo'] ?></td>
        <td><?= $proveedor['direccion'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>