<?php
/**
 * @var AreaGastos $areaGasto
 */
?>
<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Area de Gastos - " . ($areaGasto->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 8; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <a href="<?= BASE_URL ?>AreasGastos" class="btn btn-volver mt-2 mb-3">Volver</a>
            <h1>Area de Gastos: <?= $areaGasto->id == 0 ? 'Nueva' : 'Editar' ?></h1>
            <form id="editarAreaGasto" class="mt-0 formulario"
                action="<?= BASE_URL ?>AreasGastos/vereditar?id=<?= $areaGasto->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $areaGasto->id ?>">

                <div class="row">
                    <div class="col-sm-4">
                        <h5>Código: *</h5>
                        <input type="text" maxlength="11" class="form-control mb-2" placeholder="Código"
                            aria-label="código nuevo" name="idnuevo" id="idnuevo" required
                            value="<?= $areaGasto->id != 0 ? $areaGasto->id : ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h5>Nombre: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombreEdit" required value="<?= $areaGasto->nombre ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h5>Departamento: *</h5>
                        <select class="form-control" id="departamentoEdit" name="departamento" required>
                            <option value="" disabled <?= $areaGasto->id == 0 ? 'selected' : '' ?>>Selecciona un
                                departamento</option>
                            <?php foreach ($departamentos as $d): ?>
                                <option value="<?= $d->id ?>" <?= $d->id == $areaGasto->departamento->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($d->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ($areaGasto->id != 0): ?>
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
$nombreBorrar = "Area de Gastos";
$idborrar = $areaGasto->id;
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