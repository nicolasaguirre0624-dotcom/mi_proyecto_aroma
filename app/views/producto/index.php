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
    

