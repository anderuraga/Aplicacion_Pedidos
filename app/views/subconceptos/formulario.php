<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Subconcepto - " . ($subconcepto->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 7; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <h1>Subconcepto: <?= $subconcepto->id == 0 ? 'Nuevo' : 'Editar' ?></h1>
            <form id="editarSubconcepto" class="mt-0" action="Subconceptos/vereditar?id=<?= $subconcepto->id ?>"
                method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $subconcepto->id ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Nombre:</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombreEdit" required value="<?= $subconcepto->nombre ?>">
                    </div>
                </div>

                <a href="<?= BASE_URL ?>Subconceptos" class="btn btn-secondary mt-2">Volver</a>

                <button type="submit"
                    class="btn btn-primary mt-2"><?= $subconcepto->id == 0 ? 'Crear' : 'Editar' ?></button>

            </form>
        </div>
    </div>
</div>


<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>