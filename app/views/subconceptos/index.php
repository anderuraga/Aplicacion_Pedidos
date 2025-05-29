<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Subconceptos" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 7; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Subconceptos</h1>
            <a href="<?= BASE_URL ?>Subconceptos/vereditar?id=0" class="btn btn-primary mb-2 ms-2 me-4">Nuevo Subconcepto</a>

            <table id="Subconceptos" class="tabla table table-striped dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subconceptos as $s): ?>
                        <tr>
                            <td><?= $s->id ?></td>
                            <td><?= htmlspecialchars($s->nombre) ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="<?= BASE_URL ?>Subconceptos/vereditar?id=<?= $s->id ?>" class="btn btn-primary">Editar</a>
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