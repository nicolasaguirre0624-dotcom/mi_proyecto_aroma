<h1>Listado de Productos</h1>
<?php if (!empty($mensaje)): ?>
    <script>alert(<?= json_encode($mensaje, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>);</script>
    <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Proveedor</th>
        <th>Categoria</th>
        <th>Acciones</th>
    </tr>
     <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['nombre'] ?? '') ?></td>
                        <td><?= htmlspecialchars($producto['precio'] ?? '') ?></td>
                        <td><?= htmlspecialchars($producto['stock'] ?? '') ?></td>
                        <td><?= htmlspecialchars($producto['nombre_proveedor'] ?? 'Sin proveedor') ?></td>
                        <td><?= htmlspecialchars($producto['nombre_categoria'] ?? 'Sin categoría') ?></td>
                        <td>
                            <a href="/aroma/public/productos?action=editar&amp;id=<?= (int) $producto['id'] ?>">Editar</a>
                            <form action="/aroma/public/productos?action=eliminar" method="POST" style="display:inline-block">
                                <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">
                                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
    
