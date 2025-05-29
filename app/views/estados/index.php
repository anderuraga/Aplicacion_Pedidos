<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Estados" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 12; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Estados</h1>

            <table id="Estados" class="tabla table table-striped dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Icono</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estados as $e): ?>
                        <tr>
                            <td><?= htmlspecialchars($e->id) ?></td>
                            <td><?= htmlspecialchars($e->nombre) ?></td>
                            <td><?= $e->icono ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="<?= BASE_URL ?>Estados/vereditar?id=<?= $e->id ?>" class="btn btn-primary">Editar</a>
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
$target = 0;
require HOMEDIR . '/../app/views/partials/footer.php' ?>