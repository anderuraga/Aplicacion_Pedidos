<?php
/**
 *  @var TipoServicio $tiposervicio
 */
?>
<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Tipo de Servicio - " . ($tiposervicio->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 4; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <a href="<?= BASE_URL ?>TiposServicio" class="btn btn-volver mt-2 mb-3">Volver</a>
            <h1>Tipo de servicio: <?= $tiposervicio->id == 0 ? 'Nueva' : 'Editar' ?></h1>
            <form id="editarTipoServicio" class="mt-0 formulario"
                action="<?= BASE_URL ?>TiposServicio/vereditar?id=<?= $tiposervicio->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $tiposervicio->id ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Nombre: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombreEdit" required value="<?= $tiposervicio->nombre ?>">
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ($tiposervicio->id != 0): ?>
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
$nombreBorrar = "Tipo de Servicio";
$idborrar = $tiposervicio->id;
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

        //$(".formulario").restoreForm();
    });
</script>

<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>