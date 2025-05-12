<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Pedidos" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<?php
/**
 * @var Pedido $pedido
 * @var Presupuesto[] $presupuestos
 */

?>
<style>
    .item-timeline>.t-time {
        margin-right: 10px !important;
    }
</style>
<div id="tableSimple" class="col-lg-8 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12 ">
                    <h1>Resumen del pedido: <?= $pedido->referencia ?></h1>
                    <a href="<?= BASE_URL ?>Pedidos" class="btn btn-danger">Volver</a>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <h5>Importe:</h5>
                    <div class="input-group mb-2">
                        <input class="form-control" placeholder="Cantidad" aria-label="cantidad"
                            aria-describedby="basic-addon2" name="cantidad" id="cantidad"
                            value="<?= $pedido->cantidad_formato() ?>" disabled>
                        <span class="input-group-text" id="basic-addon2">€</span>
                    </div>
                </div>
                <div class="col-4">
                    <h5>Referencia:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->referencia ?>" disabled>
                </div>
                <div class="col-4">
                    <h5>Fecha creación:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->getFechaCreadaVisible() ?>"
                        disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <h5>Departamento:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->departamento->nombre ?>" disabled>
                </div>
                <div class="col-4">
                    <h5>Usuario:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->usuario->nombre ?>" disabled>
                </div>
                <div class="col-4">
                    <h5>Area Gasto:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->areaGastos->nombre ?>" disabled>
                </div>
            </div>
            <h4 class="mt-2">Proveedor: <?= $pedido->proveedor->nombre ?></h4>
            <a id="detallesLink" onclick="toggleDetalles()">+ Mostrar Detalles</a>
            <div id="detallesProveedor" class="row p-3" style="display: none;">
                <div class="col-4">
                    <h5>CIF:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->proveedor->cif ?>" disabled>
                </div>
                <div class="col-4">
                    <h5>Dirección:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->proveedor->direccion_completa() ?>"
                        disabled>
                </div>
                <div class="col-4">
                    <h5>Teléfono:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->proveedor->telefono ?>" disabled>
                </div>
                <div class="col-4">
                    <h5>Correo Electrónico:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->proveedor->correo ?>" disabled>
                </div>
                <div class="col-4">
                    <h5>Contacto:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->proveedor->contacto ?>" disabled>
                </div>
                <div class="col-4">
                    <h5>Servicio:</h5>
                    <input type="text" class="form-control mb-2"
                        value="<?= $pedido->proveedor->tipo_servicio->nombre ?>" disabled>
                </div>
                <div class="col-4">
                    <h5>Factura electrónica:</h5>
                    <input type="text" class="form-control mb-2"
                        value="<?= $pedido->proveedor->factura_electronica ? 'Si' : 'No' ?>" disabled>
                </div>
            </div>
            <h4 class="mt-2">Detalles:</h4>
            <div class="row">
                <div class="col-4">
                    <h5>Subconcepto:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->subconcepto->nombre ?>" disabled>
                </div>
                <div class="col-4">
                    <h5>Tipo:</h5>
                    <input type="text" class="form-control mb-2" value="<?= $pedido->subconcepto->tipo->name ?>"
                        disabled>
                </div>

            </div>
            <div class="row">
                <div class="col-6">
                    <h5>Descripción de la solicitud:</h5>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                        disabled><?= $pedido->descripcion ?></textarea>
                </div>
            </div>

            <div id="incidenciasDiv" style="display:none;">
                <h4 class="mt-2">Incidencias:</h4>
                <h5>Incidencia registrada el 07/03/2025:</h5>
                <textarea class="form-control" name="descripcion" rows="3"
                    disabled>Los paquetes han venido dañados y la empresa dice que no se hace cargo</textarea>
            </div>
            <div class="row mx-4 my-3">
                <div class="col-6">
                </div>
                <div class="col-6">
                    <button id="botoncontinuar" class="btn btn-success float-end">Guardar</button>
                </div>

            </div>
        </div>
    </div><!-- Cierra statbox widget box box-shadow -->
</div> <!-- Cierra tableSimple -->
<div id="sideDiv" class="col-lg-4 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-2">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h2>Estado: <?= $pedido->estado->nombre ?></h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 ">
                    <?php switch ($pedido->estado->id) {
                        case 1: ?>
                            <?php if ($pedido->comprobacion_presupuestos()): ?>
                                <div class="col-12 mb-3" id="subirfacturadiv">
                                    <h5>Subir facturas:</h5>
                                    <div class="mb-2">
                                        <form id="subirFacturas" method="post" action="Pedidos/vereditar?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="siguiente">
                                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                            <h5>Presupuesto Seleccionado:</h5>
                                            <input type="text" class="form-control" id="presupuesto1_referencia" name="presupuesto1_referencia" placeholder="Referencia">
                                            <input type="file" id="presupuesto" name="presupuesto1" accept="application/pdf">
                                            <h5>Presupuesto alternativo 1:</h5>
                                            <input type="text" class="form-control" id="presupuesto2_referencia" name="presupuesto2_referencia" placeholder="Referencia">
                                            <input type="file" id="presupuesto2" name="presupuesto2" accept="application/pdf">
                                            <h5>Presupuesto alternativo 2:</h5>
                                            <input type="text" class="form-control" id="presupuesto3_referencia" name="presupuesto3_referencia" placeholder="Referencia">
                                            <input type="file" id="presupuesto3" name="presupuesto3" accept="application/pdf">
                                            <h5><a>Anexo III, Anexo XV </a></h5>
                                            <input type="file" id="anexo" name="anexo" accept="application/pdf">
                                            <button class="btn btn-success float-end">Enviar</button><br>
                                        </form>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-12 mb-2" id="subirfacturadiv">
                                    <form id="subirFactura" method="post" action="Pedidos/vereditar?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="siguiente">
                                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                        <h5>Presupuesto Seleccionado:</h5>
                                        <input type="text" class="form-control" id="presupuesto1_referencia" name="presupuesto1_referencia" placeholder="Referencia">
                                        <input type="file" id="presupuesto" name="presupuesto1" accept="application/pdf">
                                        <button class="btn btn-success float-end">Enviar</button><br>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php break;
                        case 2: ?>
                            <?php if ($usuario->tipo == 1) { ?>
                                <form class="mb-2" id="seguir" method="post" action="Pedidos/vereditar?id=<?= $_GET['id'] ?>">
                                    <input type="hidden" name="action" value="siguiente">
                                    <button class="btn btn-success float-end">Enviar Proveedor</button><br>
                                </form>
                            <?php } ?>
                        <?php break;
                        case 3: ?>
                            <h5>Subir albarán:</h5>
                            <form class="mb-2" id="subirFacturas" method="post" action="Pedidos/vereditar?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                <input type="file" id="albaran" name="albaran" accept="application/pdf">
                                <button class="btn btn-success float-end">Subir Albarán</button><br>
                            </form>
                        <?php break;
                        case 4: ?>
                            <h5>Subir factura:</h5>
                            <form class="mb-2" id="subirFacturas" method="post" action="Pedidos/vereditar?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                <input type="file" id="factura" name="factura" accept="application/pdf">
                                <button class="btn btn-success float-end">Subir factura</button><br>
                            </form>
                        <?php break;
                        case 5: ?>
                            <?php if ($usuario->tipo == 1) { ?>
                                <form class="mb-2" id="seguir" method="post" action="Pedidos/vereditar?id=<?= $_GET['id'] ?>">
                                    <input type="hidden" name="action" value="siguiente">
                                    <button class="btn btn-success float-end">Confirmar Pago</button><br>
                                </form>
                            <?php } ?>
                    <?php break;
                        default:
                            # code...
                            break;
                    } ?>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#nuevaIncidenciaModal">Nueva Incidencia</button>
                    <button class="btn btn-light-success mr-a">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="statbox widget box box-shadow mt-2">
        <div class="widget-content widget-content-area p-2">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h2>Documentos</h2>
                </div>
            </div>
            <?php
            if ($pedido->estado->id == 1) {
                echo "<h5>Todavía no hay documentos subidos</h5>";
            } else {
            ?>
                <h5 class="mb-0">Presupuesto seleccionado</h5>
                <p class="mb-0">Referencia: <?= $presupuestos[0]->referencia ?></p>
                <a target="_blank" href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $presupuestos[0]->documento ?>">Ver Presupuesto</a>
                <?php if ($pedido->comprobacion_presupuestos()) { ?>
                    <h5 class="mb-0 mt-2">Presupuesto alternativo 1</h5>
                    <p class="mb-0">Referencia: <?= $presupuestos[1]->referencia ?></p>
                    <a target="_blank" href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $presupuestos[1]->documento ?>">Ver Presupuesto</a>
                    <h5 class="mb-0 mt-2">Presupuesto alternativo 2</h5>
                    <p class="mb-0">Referencia: <?= $presupuestos[2]->referencia ?></p>
                    <a target="_blank" href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $presupuestos[2]->documento ?>">Ver Presupuesto</a>
                    <h5 class="mb-0 mt-2">Anexo III, Anexo XV</h5>
                    <a target="_blank" href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pedido->anexo ?>">Ver Anexos</a>

                <?php } ?>
                <?php if ($pedido->estado->id >= 4) { ?>
                    <h5 class="mb-0 mt-2">Albarán</h5>
                    <a target="_blank" href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pedido->albaran ?>">Ver Albarán</a>
                <?php } ?>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="statbox widget box box-shadow mt-2">
        <div class="widget-content widget-content-area p-2">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h2>Historial</h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 ">
                    <div class="mt-container mx-auto">
                        <div class="timeline-line">
                            <?php
                            /**
                             * @var Historial $h
                             */
                            foreach ($historial as $h) {
                            ?>
                                <div class="item-timeline">
                                    <p class="t-time"><?= $h->getFechaVisible() ?></p>
                                    <div class="t-dot t-dot-warning">
                                    </div>
                                    <div class="t-text">
                                        <p><?= $h->comentario ?></p>
                                        <p class="t-meta-time"><?= $h->getHoraVisible() ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleDetalles() {
        $("#detallesProveedor").toggle();
    }
</script>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>