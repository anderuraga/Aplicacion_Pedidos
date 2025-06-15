<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Reportes" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 6; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <h1>Reportes</h1>
            <form method="get">
                <div class="row mb-2">
                    <div class="col-4">
                        <input class="form-control" type="number" min="2000" max="3000" required step="1" id="anio" name="anio" value="<?= $anio ?>">
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-success mt-1">Cargar</button>
                    </div>
                </div>
                <h2>Facturas</h2>
                <table id="facturas" class="tabla table table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th></th>
                            <th>Cantidad</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($infoFacturas as $f) { ?>
                            <tr>
                                <td><?= $f["estado"] ?></td>
                                <td></td>
                                <td><?= $f["num_facturas"] ?></td>
                                <td><?= $f["total_importe"] ?>€</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h2>Areas Gastos</h2>
                <table id="AreasGastos" class="tabla table table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th></th>
                            <th>Area Gsato</th>
                            <th>Departamento</th>
                            <th>Gasto</th>
                            <th>Restante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($infoAreasGastos as $a) { ?>
                            <tr>
                                <td><?= $a["id_area"] ?></td>
                                <td></td>
                                <td><?= $a["nombre_area"] ?></td>
                                <td><?= $a["nombre_departamento"] ?></td>
                                <td><?= $a["total_gastos"] ?>€</td>
                                <td><?= $a["total"] ?>€</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h2>Proveedores</h2>
                <div class="row m-4">
                    <div class="col-4 servicioDiv">
                        <h5>Filtrar proveedor por servicio:</h5>
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
                </div>
                <table id="Proveedores" class="tabla table table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>id servicio</th>
                            <th>Proveedor</th>
                            <th>Tipo Servicio</th>
                            <th>Pedidos</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($infoProveedores as $p) { ?>
                            <tr>
                                <td><?= $p["id_proveedor"] ?></td>
                                <td><?= $p["id_tipo_servicio"] ?></td>
                                <td><?= $p["nombre_proveedor"] ?></td>
                                <td><?= $p["tipo_servicio"] ?></td>
                                <td><?= $p["num_pedidos"] ?></td>
                                <td><?= $p["total_importe"] ?>€</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

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

        $("#servicio").on("change", function() {
            $("#radio_btn").prop('checked', false)
            tabla.columns(1)
                .search($(this).val())
                .draw();
        });
    });
</script>
<?php
$extraColumndef = "{
                target: 1,
                visible: false,
                searchable: true
            }"
    ?>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>