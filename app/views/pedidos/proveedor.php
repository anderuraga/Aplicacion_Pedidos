<?php $titulo = "Pedidos" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <a href="<?= BASE_URL ?>Pedidos" class="btn btn-danger mx-3 mt-3 mb-3">Volver</a>
            <h1 class="mb-0 ms-2">Nuevo Pedido:</h1>
            <div class="bs-stepper stepper-form-one linear">
                <div class="bs-stepper-header" role="tablist">
                    <div class="step active" data-target="#defaultStep-one">
                        <button type="button" class="step-trigger" role="tab" aria-selected="true">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Seleccionar Proveedor</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#defaultStep-two">
                        <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                            <span class=" bs-stepper-circle">2</span>
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

            <form id="selec_proveedor" action="<?= BASE_URL ?>Pedidos/proveedor" method="post">
                <div class="row m-4">
                    <div class="col-4 servicioDiv">
                        <h5>Filtrar proveedor por servicio:</h5>
                        <select class="form-control" id="servicio" name="servicio">
                            <option value="-1" selected>------- TODOS -------</option>
                            <?php
                            /** @var TipoServicio $t */
                            foreach ($tiposServicio as $t) {
                                ?>
                                <option value="<?= $t->id ?>"><?= $t->nombre ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <table id="Proveedores" class="tabla table table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>tipoServicioId</th>
                            <th><!--selector proveedor--></th>
                            <th>Servicio</th>
                            <th>Razón Social</th>
                            <th>Población</th>
                            <th>F.E.</th>
                            <th>Gasto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proveedores as $p) { ?>
                            <tr>
                                <td><?= $p->tipo_servicio->id ?></td>
                                <td>
                                    <div class="form-radio form-radio-primary form-radio-inline">
                                        <input class="form-radio-input proveedorRadio" type="radio" name="proveedor"
                                            value="<?= $p->id ?>">
                                    </div>
                                </td>
                                <td><?= $p->tipo_servicio->nombre ?></td>
                                <td><?= $p->nombre ?></td>
                                <td><?= $p->poblacion ?></td>
                                <td><?= $p->factura_electronica ? 'Si' : 'No' ?></td>
                                <td><?= $p->cantidad_formato() ?>€</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="row mx-4 my-1">
                    <div class="col-12">
                        <button type="submit" id="botoncontinuar" class="btn btn-success float-end">Siguiente</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        $("#servicio").on("change", function () {
            if ($(this).val() != -1) {
                $("#radio_btn").prop('checked', false)
                tabla.columns(0)
                    .search($(this).val())
                    .draw();
            }else{
                tabla.columns(0)
                    .search("")
                    .draw();
            }

        });
    });

</script>
<?php
$target = 6;
$extraColumndef = "{
                target: 0,
                visible: false,
                searchable: true
            }"
    ?>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>