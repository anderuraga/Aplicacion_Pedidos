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
            <form id="selec_proveedor" action="Pedidos/proveedor" method="post" >
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
                <table id="Proveedores" class="tabla table table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>tipoServicioId</th>
                            <th>CIF</th>
                            <th></th>
                            <th>Razón Social</th>
                            <th>Dirección</th>
                            <th title="Código Postal">C.P.</th>
                            <th>Población</th>
                            <th>Provincia</th>
                            <th>Servicio</th>
                            <th>F.E.</th>
                            <th>Gasto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proveedores as $p) { ?>
                            <tr>
                                <td><?= $p->id ?></td>
                                <td><?= $p->tipo_servicio->id ?></td>
                                <td><?= $p->cif ?></td>
                                <td>
                                    <div class="form-radio form-radio-primary form-radio-inline">
                                        <input class="form-radio-input proveedorRadio" type="radio" name="proveedor"
                                            value="<?= $p->id ?>">
                                    </div>
                                </td>
                                <td><?= $p->nombre ?></td>
                                <td><?= $p->direccion ?></td>
                                <td><?= $p->cod_postal ?></td>
                                <td><?= $p->poblacion ?></td>
                                <td><?= $p->provincia ?></td>
                                <td><?= $p->tipo_servicio->nombre ?></td>
                                <td><?= $p->factura_electronica ? 'Si' : 'No' ?></td>
                                <td><?= $p->cantidad_formato() ?>€</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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

        $("#servicio").on("change", function () {
            $("#radio_btn").prop('checked', false)
            tabla.columns(1)
                .search($(this).val())
                .draw();
        });
    });

</script>
<?php
$target = 2;
$extraColumndef = "{
                target: 1,
                visible: false,
                searchable: true
            }"
    ?>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>