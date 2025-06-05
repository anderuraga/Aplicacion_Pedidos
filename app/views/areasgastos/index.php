<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Area de Gastos"; ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 8; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>


<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Areas de Gastos</h1>

            <table id="areasgastos" class="tabla table table-striped dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Departamento</th>
                        <th>Ingresos</th>
                        <th>Gastos Pendiente</th>
                        <th>Gastos</th>
                        <th>Disponible</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($areasGastos as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a->id) ?></td>
                            <td><?= htmlspecialchars($a->nombre) ?></td>
                            <td><?= htmlspecialchars($a->departamento->nombre) ?></td>
                            <td><?= $a->ingresos_formato() ?>€</td>
                            <td><?= $a->gastos_pendiente_formato() ?>€</td>
                            <td><?= $a->gastos_formato() ?>€</td>
                            <td><?= $a->diferencia_formato() ?>€</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="<?= BASE_URL ?>AreasGastos/vereditar?id=<?= $a->id ?>" class="btn btn-primary">Editar</a>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="<?= BASE_URL ?>AreasGastos/historial?id=<?= $a->id ?>" class="btn btn-primary">Historial</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>