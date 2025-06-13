<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Inventario - Movimiento"  ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 11; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<?php 
/**
 * @var Movimiento $movimiento
 */
?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <a href="<?= BASE_URL ?>Inventario/historial?id=<?= $_GET['item'] ?>" class="btn btn-secondary mt-2 mb-3">Volver</a>
            <h1>Item: Movimiento</h1>
            <form id="editarMovimiento" class="mt-0 formulario" action="<?= BASE_URL ?>Inventario/movimiento?id=<?= $movimiento->id ?>&item=<?= $_GET['item'] ?>"
                method="post">
                <input type="hidden" id="id" name="id" value="<?= $movimiento->id ?>">
                <input type="hidden" id="item_id" name="item_id" value="<?= $_GET['item'] ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Tipo: *</h5>
                        <div class="form-check form-check-primary form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoEdit" value="Entrada" required <?= $movimiento->cantidad>0?'checked':'' ?>>
                            <label class="form-check-label" for="tipo">
                                Entrada
                            </label>
                        </div>
                        <div class="form-check form-check-primary form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoEdit" value="Salida" required <?= $movimiento->cantidad<0?'checked':'' ?>>
                            <label class="form-check-label" for="form-check-radio-default">
                                Salida
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Cantidad: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Cantidad" aria-label="cantidad"
                            name="cantidad" id="cantidad" required value="<?= abs($movimiento->cantidad) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h5>Fecha: *</h5>
                        <input type="text" class="form-control flatTime mb-2" placeholder="Fecha" aria-label="fecha"
                            name="fecha" id="fecha" required value="<?= $movimiento->fecha ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h5>Descripción: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Descripción" aria-label="descripcion"
                            name="descripcion" id="descripcion" required value="<?= $movimiento->descripcion ?>">
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
        let datepickers = $('.flatTime').flatpickr({
            altInput: true,
            altFormat: "d-m-Y",
            dateFormat: "Y-m-d",
        })

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