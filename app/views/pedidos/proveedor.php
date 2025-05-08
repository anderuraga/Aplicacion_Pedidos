<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Pedidos" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Nuevo Pedido: Proveedor</h1>
            <div class="row m-4">
                <div class="col-4">
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
                <div class="col-4 servicioDiv">
                    <h5>Servicio:</h5>
                    <select class="form-control" id="servicio" name="servicio">
                        <option value="" disabled selected hidden>Selecciona una opción</option>
                        <?php
                        /** @var TipoServicio $t */
                        foreach ($tiposServicio as $t) {
                            ?>
                            <option value="<?= $t->id ?>"><?= $t->nombre ?></optionv>
                            <?php } ?>
                    </select>
                </div>
                <div class="col-4 areagastoDiv" style="display: none;">
                    <h5>Area de Gasto:</h5>
                    <select class="form-control" id="areagasto" name="areagasto">
                        <option value="0" data-depart="0" disabled selected hidden>Selecciona una opción</option>
                        <?php
                        /** @var AreaGastos $a */
                        foreach ($areasGastos as $a) { ?>
                            <option value="<?= $a->id ?>" data-depart="<?= $a->departamento->id ?>"><?= $a->nombre ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

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
    });

</script>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>