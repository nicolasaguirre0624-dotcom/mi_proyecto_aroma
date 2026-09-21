<h2>Listado de Productos - Tienda Aroma</h2>

    <?php if (isset($productos['error'])): ?>
        <p class="error"><?php echo $productos['error']; ?></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Producto</th>
                    <th>Precio Venta</th>
                    <th>Precio Compra</th>
                    <th>Stock</th>
                    <th>Marca</th>
                    <th>Tipo de Producto</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['idProducto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombreProducto']); ?></td>
                            <td>$<?php echo number_format($producto['precioProducto'], 2); ?></td>
                            <td><?php echo isset($producto['valorComprada']) ? '$' . number_format($producto['valorComprada'], 2) : 'N/A'; ?></td>
                            <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombreMarca'] ?? 'Sin marca'); ?></td>
                            <td><?php echo htmlspecialchars($producto['nTipoProduct'] ?? 'Sin tipo'); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="7" style="text-align: center;">No hay productos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    
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

