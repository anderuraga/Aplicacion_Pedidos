<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Tipos de Servicio" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 4; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Tipos de servicio</h1>
            <a href="TiposServicio/vereditar?id=0" class="btn btn-primary mb-2 ms-2 me-4">Nuevo Departamento</a>

            <table id="TiposServicio" class="tabla table table-striped dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tiposservicio as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t->id) ?></td>
                            <td><?= htmlspecialchars($t->nombre) ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="TiposServicio/vereditar?id=<?= $t->id ?>" class="btn btn-primary">Editar</a>
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