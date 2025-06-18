<?php
/**
 * @var Departamento $departamento
 */
?>
<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Departamentos - " . ($departamento->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 2; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <a href="<?= BASE_URL ?>Departamentos" class="btn btn-secondary mt-2 mb-2">Volver</a>
            <h1>Departamento: <?= $departamento->id == 0 ? 'Nueva' : 'Editar' ?></h1>
            <form id="editarDepartamento" class="mt-0 formulario"
                action="<?= BASE_URL ?>Departamentos/vereditar?id=<?= $departamento->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $departamento->id ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Nombre: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombreEdit" required value="<?= $departamento->nombre ?>">
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ($departamento->id != 0): ?>
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
$nombreBorrar = "Departamento";
$idborrar = $departamento->id;
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