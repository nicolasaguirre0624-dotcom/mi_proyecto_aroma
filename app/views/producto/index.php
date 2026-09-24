<h1>Listado de Productos</h1>
<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Proveedor</th>
        <th>Categoria</th>
    </tr>
     <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['nombre'] ?? '') ?></td>
                        <td><?= htmlspecialchars($producto['precio'] ?? '') ?></td>
                        <td><?= htmlspecialchars($producto['stock'] ?? '') ?></td>
                        <td><?= htmlspecialchars($producto['nombre_proveedor'] ?? 'Sin proveedor') ?></td>
                        <td><?= htmlspecialchars($producto['nombre_categoria'] ?? 'Sin categoría') ?></td>
                    </tr>
                <?php endforeach; ?>
    
</table>
<h1>Producto consultado</h1>
<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Proveedor</th>
        <th>Categoria</th>
    </tr>
    <tr>
        <td><?= $producto['nombre'] ?></td>
        <td><?= $producto['precio'] ?></td>
        <td><?= $producto['stock'] ?></td>
        <td><?= $producto['nombre_proveedor'] ?></td>
        <td><?= $producto['nombre_categoria'] ?></td>
    </tr>
</table>

