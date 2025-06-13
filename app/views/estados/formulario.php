<?php
/**
 * @var Estado $estado
 */
?>
<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Estados - Editar" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 12; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <a href="<?= BASE_URL ?>Estados"
                    class="btn btn-secondary mt-2 mb-3">Volver</a>
            <h1>Estados: Editar</h1>
            <form id="editarEstado" class="mt-0 formulario"
                action="<?= BASE_URL ?>Estados/vereditar?id=<?= $estado->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $estado->id ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Nombre: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombreEdit" required value="<?= $estado->nombre ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Icono:</h5>
                        <textarea id="icono" name="icono" rows="5" class="form-control"><?= $estado->icono ?></textarea>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                </div>



            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('.formulario').find('input:required').on('blur', function () {
            if ($.trim($(this).val()) === '') {
                $(this).addClass('required-vacio');
            } else {
                $(this).removeClass('required-vacio');
            }
        });

        //$(".formulario").restoreForm();
    });
</script>

<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>