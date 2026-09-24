<h1>Listado de Compras</h1>
<table border="2">
    <tr>
        <th>ID Compra</th>
        <th>Proveedor</th>
        <th>Fecha Compra</th>
        <th>Tipo Pago</th>
        <th>IVA</th>
        <th>Valor Compra</th>
    </tr>
    <?php if (!empty($compras) && is_array($compras)): ?>
        <?php foreach ($compras as $compra): ?>
            <tr>
                <td><?= $compra['idCompra'] ?? '' ?></td>
                <td><?= $compra['nombre_proveedor'] ?? ($compra['int_proveedor'] ?? 'Sin proveedor') ?></td>
                <td><?= $compra['fechaCompra'] ?? '' ?></td>
                <td><?= $compra['idTipoPago'] ?? '' ?></td>
                <td><?= $compra['ivaCompra'] ?? '' ?></td>
                <td><?= $compra['valorCompra'] ?? '' ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No hay compras registradas.</td>
        </tr>
    <?php endif; ?>
</table>