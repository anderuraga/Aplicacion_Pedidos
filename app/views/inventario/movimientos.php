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
                    <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal"
                        data-bs-target="#borrarModal">Borrar</button>
                    <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                </div>
                

            </form>
        </div>
    </div>
</div>
<div class="modal fade inputForm-modal" id="borrarModal" tabindex="-1" role="dialog" aria-labelledby="borrarModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" id="borrarModalLabel">
                <h5 class="modal-title">Borrar Movimiento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form id="borrarForm" class="mt-0" method="post">
                    <input type="hidden" name="id" value="<?= $movimiento->id ?>">
                    <input type="hidden" name="action" value="borrar">
                    <h5>Una vez borrado los datos no se podrán recuperar</h5>
                    <h5>Para confirmar la acción, escribe "Borrar" en el campo siguiente: </h5>
                    <input type="text" name="confirmacion" class="form-control">
                </form>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-light-primary mt-2 mb-2 btn-no-effect"
                    data-bs-dismiss="modal">Cancelar</button>
                <button id="submitButton" type="submit" form="borrarForm"
                    class="btn btn-danger mt-2 mb-2 btn-no-effect">Borrar</button>
            </div>
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