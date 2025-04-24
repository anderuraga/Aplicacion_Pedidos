<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Departamentos" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 2; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Departamentos</h1>
            <a href="Departamentos/vereditar?id=0" class="btn btn-primary mb-2 ms-2 me-4">Nueva area de gastos</a>

            <table id="Departamentos" class="tabla table table-striped dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($departamentos as $d): ?>
                        <tr>
                            <td><?= htmlspecialchars($d->id) ?></td>
                            <td><?= htmlspecialchars($d->nombre) ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="Departamentos/vereditar?id=<?= $d->id ?>" class="btn btn-primary">Editar</a>
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