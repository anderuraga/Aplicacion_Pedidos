<?php $titulo = "Pedidos" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">

            <h1 class="mb-0 ms-2">Nuevo Pedido:</h1>
            <div class="bs-stepper stepper-form-one linear">
                <div class="bs-stepper-header" role="tablist">
                    <div class="step " data-target="#defaultStep-one">
                        <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Seleccionar Proveedor</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step active" data-target="#defaultStep-two">
                        <button type="button" class="step-trigger" role="tab" aria-selected="true">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Seleccionar area de gasto</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#defaultStep-three">
                        <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Rellenar detalles</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>


            <form id="selec_area_gasto" action="Pedidos/areagastos?proveedor=<?= $_GET['proveedor'] ?>" method="post">
                <input type="hidden" id="proveedor" name="proveedor" value="<?= $_GET['proveedor'] ?>">
                <div class="row m-4">
                    <div class="col-4 departamento">
                        <h5>Departamento:</h5>
                        <?php
                        /** @var Usuario $usuario */
                        if ($usuario->tipo == 1) { ?>
                            <select class="form-control" id="departamento" name="departamento">
                                <option value="" disabled selected hidden>Selecciona una opción</option>
                                <?php
                                /** @var Departamento $d */
                                foreach ($departamentos as $d) { ?>
                                    <option value="<?= $d->id ?>"><?= $d->nombre ?></option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <h5><?= $usuario->departamento->nombre ?></h5>
                            <input type="hidden" id="departamento" name="departamento"
                                value="<?= $usuario->departamento->id ?>">
                        <?php } ?>
                    </div>
                    <div class="col-4 areagastoDiv" style="display: none;">
                        <h5>Area de Gasto:</h5>
                        <select class="form-control" id="areagasto" name="areagasto">
                            <option value="0" data-depart="0" disabled selected hidden>Selecciona una opción</option>
                            <?php
                            /** @var AreaGastos $a */
                            foreach ($areasGastos as $a) { ?>
                                <option value="<?= $a->id ?>" data-disponible="<?= $a->diferencia_formato() ?>€" data-depart="<?= $a->departamento->id ?>"><?= $a->nombre ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-4 disponibleDiv" style="display: none;">
                        <h5>Saldo disponible:</h5>
                        <h5 id="cantidad"></h5>
                    </div>
                </div>
                <div class="row mx-4 my-1">
                    <div class="col-6">
                        <a href="<?= BASE_URL ?>Pedidos" class="btn btn-danger">Volver</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" id="botoncontinuar" class="btn btn-success float-end">Continuar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function filtrarAreasGastos(departamento) {
        $('#areagasto option').prop("disabled", true);
        $('#areagasto option[ata-depart!=0]').prop("hidden", true);
        $('#areagasto option[data-depart=' + departamento + ']').prop("disabled", false).prop("hidden", false);
        $("#areagasto").val(0);
    }

    document.addEventListener("DOMContentLoaded", () => {
        $("#departamento").on("change", function () {
            if ($("#departamento").val() == 0) {
                $(".areagastoDiv").hide();
            } else {
                filtrarAreasGastos($("#departamento").val())
                $(".areagastoDiv").show();
            }
        });

        $("#areagasto").on("change", function () {
            if ($("#areagasto").val() == 0) {
                $(".disponibleDiv").hide();
            } else {
                $('#cantidad').html($('#areagasto option:selected').data("disponible"));
                $(".disponibleDiv").show();
            }
        });

        <?php if ($usuario->tipo == 0) { ?>
            filtrarAreasGastos($("#departamento").val())
            $(".areagastoDiv").show();
            <?php
        } ?>
    });

</script>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>