<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Pedido: Detalles" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<?php
/**
 * @var Departamento $departamento
 * @var AreaGastos $areaGastos
 * @var Proveedor $proveedor
 */
?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area ps-3">
            <a href="<?= BASE_URL . "Pedidos/proveedor" ?>" class="btn btn-danger mt-2 mb-3">Volver</a>
            <h1 class="mt-2 mb-0 ms-2">Nuevo pedido:</h1>
            <div class="bs-stepper stepper-form-one linear">
                <div class="bs-stepper-header" role="tablist">
                    <div class="step " data-target="#defaultStep-one">
                        <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Seleccionar Proveedor</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step " data-target="#defaultStep-two">
                        <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Seleccionar area de gasto</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step active" data-target="#defaultStep-three">
                        <button type="button" class="step-trigger" role="tab" aria-selected="true">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Rellenar detalles</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <form method="post"
                action="<?= BASE_URL ?>Pedidos/detalles?proveedor=<?= $_GET['proveedor'] ?>&areaGasto=<?= $_GET['areaGasto'] ?>&departamento=<?= $departamento->id ?>"
                class="formulario">
                <input type="hidden" name="proveedor" value="<?= $_GET['proveedor'] ?>">
                <input type="hidden" name="areaGasto" value="<?= $_GET['areaGasto'] ?>">
                <input type="hidden" name="departamento" value="<?= $departamento->id ?>">

                <div class="row">
                    <div class="col-4">
                        <h4>Departamento:</h4>
                        <h5><?= $departamento->nombre ?></h5>
                    </div>
                    <div class="col-4">

                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <h4>Proveedor:</h4>
                        <h5><?= $proveedor->nombre ?></h5>
                        <h4>Gasto en año contable:</h4>
                        <h5><?= $proveedor->cantidad_formato() ?>€ / <?= $proveedor->limite_formato() ?>€</h5>
                    </div>
                    <div class="col-4">
                        <h4>Area gasto:</h4>
                        <h5><?= $areaGastos->nombre ?></h5>
                        <h4>Saldo:</h4>
                        <h5><?= $areaGastos->diferencia_formato() ?>€</h5>
                    </div>
                </div>
                <h4 class="mt-2">Detalles:</h4>
                <div class="row">
                    <div class="col-4">
                        <h5>Subconcepto: *</h5>
                        <select class="form-control" id="subconcepto" name="subconcepto" required>
                            <option value="" disabled selected hidden>Selecciona una opción</option>
                            <?php
                            /** @var Subconcepto $s */
                            foreach ($subconceptos as $s) { ?>
                                <option value="<?= $s->id ?>"><?= $s->nombre ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <h5>Importe: *</h5>
                        <div class="input-group mb-2">
                            <input class="form-control" placeholder="Cantidad" aria-label="cantidad"
                                aria-describedby="basic-addon2" name="cantidad" id="cantidad" required>
                            <span class="input-group-text" id="basic-addon2">€</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h5>Descripción de la solicitud: *</h5>
                        <textarea required class="form-control" id="descripcion" name="descripcion" rows="3"
                            placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. In iaculis erat justo, ac cursus nibh."></textarea>
                    </div>
                </div>
                <div class="row mx-4 my-1">
                    
                    <div class="col-12">
                        <button type="submit" id="botoncontinuar" class="btn btn-success float-end">Gurdar</d>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $("#cantidad").inputmask("currency", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 2,
            autoGroup: true,
            prefix: ''
        });

        $('.formulario').find('input:required, textarea:required').on('blur', function () {
            if ($.trim($(this).val()) === '') {
                $(this).addClass('required-vacio');
            } else {
                $(this).removeClass('required-vacio');
            }
        });
    });
</script>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>