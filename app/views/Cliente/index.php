<h1>Listado de Clientes</h1>
<table border="2">
    <tr>
        <th>Nombre</th>
        <th>documento</th>
        <th>Correo</th>
        <th>Telefono</th>
      
    </tr>
    <?php foreach ($clientes as $cliente): ?>
    <tr>
        <td><?= $cliente['nombre'] ?></td>
        <td><?= $cliente['documento'] ?></td>
        <td><?= $cliente['correo'] ?></td>
        <td><?= $cliente['telefono'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>