<?php
/**
 * @var Transaccion $ingreso
 */
?>
<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Ingresos - " . ($ingreso->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 9; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <a href="<?= BASE_URL ?>Ingresos" class="btn btn-secondary mt-2 mb-3">Volver</a>
            <h1>Ingresos: <?= $ingreso->id == 0 ? 'Nuevo' : 'Editar' ?></h1>
            <form id="editarIngreso" class="mt-0 formulario"
                action="<?= BASE_URL ?>Ingresos/vereditar?id=<?= $ingreso->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $ingreso->id ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Fecha: *</h5>
                        <input type="text" class="form-control flatTime mb-2" placeholder="Fecha" aria-label="fecha"
                            name="fecha" id="fecha" required value="<?= $ingreso->fecha ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h5>Descripción: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Descripción" aria-label="descripcion"
                            name="descripcion" id="descripcion" required value="<?= $ingreso->descripcion ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h5>Area de gasto: *</h5>
                        <select class="form-control mb-2" name="areagasto" id="areagasto" required>
                            <option value="" disabled <?= $ingreso->id == 0 ? 'selected' : '' ?>>Selecciona una area de
                                gasto</option>
                            <?php foreach ($areasgastos as $a): ?>
                                <option value="<?= $a->id ?>" <?= $a->id == $ingreso->areaGastos->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($a->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h5>Cantidad: *</h5>
                        <div class="input-group mb-2">
                            <input class="form-control" placeholder="Cantidad" aria-label="cantidad"
                                aria-describedby="basic-addon2" name="cantidad" id="cantidad"
                                value="<?= $ingreso->cantidad ?>" required>
                            <span class="input-group-text" id="basic-addon2">€</span>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ($ingreso->id != 0): ?>
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
$nombreBorrar = "Ingreso";
$idborrar = $ingreso->id;
require __DIR__ . '/../partials/borrarmodal.php';
?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let datepickers = $('.flatTime').flatpickr({
            altInput: true,
            altFormat: "d-m-Y",
            dateFormat: "Y-m-d",
        })

        $("#cantidad").inputmask("currency", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 2,
            autoGroup: true,
            prefix: ''
        });

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