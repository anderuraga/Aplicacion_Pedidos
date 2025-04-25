<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Area de Gastos - Historial" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 8; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div class="row layout-top-spacing">
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <h1 class="mt-2 ms-2">Area de Gastos: <?= $area->nombre ?></h1>

                <table id="areasgastos" class="tabla table table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Operación</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transacciones as $t): ?>
                            <tr>
                                <td><?= $t->id ?></td>
                                <td data-sort="<?= $t->fecha ?>"><?= $t->getFechaVisible() ?></td>
                                <td><?= htmlspecialchars($t->descripcion) ?></td>
                                <td><?= $t->getOperacion() ?></td>
                                <td><?= $t->cantidad_formato() ?>€</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="<?= BASE_URL ?>AreasGastos" class="btn btn-secondary m-2">Volver</a>
            </div>
        </div>
    </div>
</div>

<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>