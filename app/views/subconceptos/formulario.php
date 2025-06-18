<?php
/**
 * @var Subconcepto $subconcepto
 */
?>
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
            <a href="<?= BASE_URL ?>Subconceptos" class="btn btn-secondary mt-2 mb-3">Volver</a>
            <h1>Subconcepto: <?= $subconcepto->id == 0 ? 'Nuevo' : 'Editar' ?></h1>
            <form id="editarSubconcepto" class="mt-0"
                action="<?= BASE_URL ?>Subconceptos/vereditar?id=<?= $subconcepto->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $subconcepto->id ?>">

                <div class="row">
                    <div class="col-sm-4">
                        <h5>código: *</h5>
                        <input type="text" maxlength="11" class="form-control mb-2" placeholder="código nuevo"
                            aria-label="código nuevo" name="idnuevo" id="idnuevo" required
                            value="<?= $subconcepto->id ?>">
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <h5>Nombre: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombreEdit" required value="<?= $subconcepto->nombre ?>">
                    </div>
                </div>




                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ($subconcepto->id != 0): ?>
                        <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal"
                            data-bs-target="#borrarModal">Borrar</button>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>
<?php
$nombreBorrar = "Subconcepto";
$idborrar = $subconcepto->id;
require __DIR__ . '/../partials/borrarmodal.php';
?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('.formulario').find('input:required').on('blur', function () {
            if ($.trim($(this).val()) === '') {
                $(this).addClass('required-vacio');
            } else {
                $(this).removeClass('required-vacio');
            }
        });
    });
</script>

<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>