<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Ingresos" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 9; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Ingresos</h1>
            <a href="Ingresos/vereditar?id=0" class="btn btn-primary mb-2 ms-2 me-4">Nuevo Ingreso</a>

            <table id="Ingresos" class="tabla table table-striped dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Fecha</th>
                        <th>Area</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ingresos as $i): ?>
                        <tr>
                            <td><?= $i->id ?></td>
                            <td data-sort="<?= $i->fecha ?>"><?= $i->getFechaVisible() ?></td>
                            <td><?= htmlspecialchars($i->area_nombre) ?></td>
                            <td><?= htmlspecialchars($i->descripcion) ?></td>
                            <td><?= $i->cantidad_formato() ?>€</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="Ingresos/vereditar?id=<?= $i->id ?>" class="btn btn-primary">Editar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
$order = 'desc';
require HOMEDIR . '/../app/views/partials/footer.php' ?>