<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Inventario - Historial" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 11; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div class="row layout-top-spacing">
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <h1 class="mt-2 ms-2">Item: <?= $item->nombre ?></h1>

                <table id="movimientos" class="tabla table table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimientos as $m): ?>
                            <tr>
                                <td><?= $m->id ?></td>
                                <td data-sort="<?= $m->fecha ?>"><?= $m->getFechaVisible() ?></td>
                                <td><?= $m->cantidad>0?'Entrada':'Salida' ?></td>
                                <td><?= htmlspecialchars($m->descripcion) ?></td>
                                <td><?= abs($m->cantidad) ?></td>
                                <td><?= $m->total ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="<?= BASE_URL ?>AreasGastos" class="btn btn-secondary m-2">Volver</a>
            </div>
        </div>
    </div>
</div>

<?php 
$order = 'desc';
require HOMEDIR . '/../app/views/partials/footer.php' ?>