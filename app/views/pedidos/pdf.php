<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1em;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 4px;
        }

        .header-table td {
            border: none;
            padding: 0;
        }

        .section {
            background: #eee;
            font-weight: bold;
        }
    </style>
</head>
<?php
/**
 * @var Pedido $pedido
 */
?>

<body>
    <!-- Logo -->
    <table class="header-table">
        <tr>
            <td style="text-align: center;">
                <img src="<?php BASE_URL ?>static/assets/img/logo/logo.png" width="500">
            </td>

        </tr>
    </table>

    <h2 style="text-align:center;">HOJA DE PEDIDO VERIFICADA Y ACEPTADA</h2>

    <!-- Datos generales -->
    <table>
        <tr>
            <td>Referencia</td>
            <td><?= $pedido->referencia ?></td>
        </tr>
        <tr>
            <td>Fecha creación</td>
            <td><?= $pedido->getFechaCreadaVisible() ?></td>
        </tr>
        <tr>
            <td>Usuario</td>
            <td><?= $pedido->usuario->nombre ?></td>
        </tr>
        <tr>
            <td>Departamento</td>
            <td><?= $pedido->departamento->nombre ?></td>
        </tr>
        <tr>
            <td>Área de gastos</td>
            <td><?= $pedido->areaGastos->nombre ?></td>
        </tr>

        <tr class="section">
            <td colspan="2">MATERIAL</td>
        </tr>
        <tr>
            <td>Importe (IVA incluido)</td>
            <td><?= $pedido->cantidad_formato() ?> €</td>
        </tr>
        <tr>
            <td>Subconcepto</td>
            <td><?= $pedido->subconcepto->nombre ?></td>
        </tr>
        <tr>
            <td>Solicitud</td>
            <td><?= $pedido->descripcion ?></td>
        </tr>

        <tr class="section">
            <td colspan="2">EMPRESA</td>
        </tr>
        <tr>
            <td>Nombre</td>
            <td><?= $pedido->proveedor->nombre ?></td>
        </tr>
        <tr>
            <td>Dirección</td>
            <td><?= $pedido->proveedor->direccion ?>,<?= $pedido->proveedor->cod_postal ?>,
                <?= $pedido->proveedor->poblacion ?></td>
        </tr>
        <tr>
            <td>Teléfono</td>
            <td><?= $pedido->proveedor->telefono ?></td>
        </tr>
        <tr>
            <td>Nº Factura</td>
            <td><?= $pedido->factura->referencia ?></td>
        </tr>
        <tr>
            <td>Fecha Factura</td>
            <td><?= $pedido->factura->fecha ?? '' ?></td>
        </tr>
    </table>
</body>

</html>