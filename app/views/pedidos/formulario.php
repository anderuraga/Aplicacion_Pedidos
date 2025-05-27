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
 * @var Incidencia[] $incidenciasActivas
 */
if (count($incidenciasActivas) > 0) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Hay <?= count($incidenciasActivas) ?> incidencia(s) abiertas en este pedido.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
}

$editable = false;
if ($pedido->estado->id == BORRADOR || $pedido->estado->id == PEN_VALI) {
    $editable = true;
}

?>
<style>
    .item-timeline>.t-time {
        margin-right: 10px !important;
    }
</style>
<div id="tableSimple" class="col-lg-8 col-12 layout-spacing formulario_pedidos">
    <div class="statbox widget box box-shadow">
        <form id="editarForm" method="post">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <input type="hidden" name="action" value="editar">
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
                                value="<?= $pedido->cantidad_formato() ?>" <?= $editable ? '' : 'disabled' ?>>
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
                        <input type="text" class="form-control mb-2" value="<?= $pedido->departamento->nombre ?>"
                            disabled>
                    </div>
                    <div class="col-4">
                        <h5>Usuario:</h5>
                        <input type="text" class="form-control mb-2" value="<?= $pedido->usuario->nombre ?>" disabled>
                    </div>
                    <div class="col-4">
                        <h5>Area Gasto:</h5>
                        <?php if ($usuario->tipo == ADMIN) { ?>
                            <select class="form-control" id="areagasto" name="areagasto">
                                <option value="0" data-depart="0" disabled selected hidden>Selecciona una opción</option>
                                <?php
                                /** @var AreaGastos $a */
                                foreach ($areasGastos as $a) { ?>
                                    <option value="<?= $a->id ?>" data-disponible="<?= $a->diferencia_formato() ?>€"
                                        data-depart="<?= $a->departamento->id ?>" <?= $a->id == $pedido->areaGastos->id ? 'selected' : '' ?>><?= $a->nombre ?>
                                    </option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <input type="text" class="form-control mb-2" value="<?= $pedido->areaGastos->nombre ?>"
                                disabled>
                        <?php } ?>
                    </div>
                </div>
                <h4 class="mt-2">Proveedor:</h4>
                <div class="row">
                    <div class="col-4">
                        <h5>Tipo de servicio:</h5>
                        <select class="form-control mb-2" id="servicio" name="servicio" <?= $editable ? '' : 'disabled' ?>>
                            <?php
                            /** @var TipoServicio $t */
                            foreach ($tiposServicios as $t) {
                                ?>
                                <option value="<?= $t->id ?>" <?= $t->id == $pedido->proveedor->tipo_servicio->id ? 'selected' : '' ?>><?= $t->nombre ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <h5>Proveedor:</h5>
                        <select class="form-control mb-2" id="proveedor" name="proveedor" <?= $editable ? '' : 'disabled' ?>>
                            <option value="0" disabled hidden>Elige una opción</option>
                            <?php
                            /** @var Proveedor $p */
                            foreach ($proveedores as $p) { ?>
                                <option value="<?= $p->id ?>" data-ts="<?= $p->tipo_servicio->id ?>"
                                    <?= $p->id == $pedido->proveedor->id ? 'selected' : '' ?>>
                                    <?= $p->cif . " - " . $p->nombre ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <a id="detallesLink" onclick="toggleDetalles()">+ Mostrar Detalles</a>
                <div id="detallesProveedor" class="row p-3" style="display: none;">
                    <div class="col-4">
                        <h5>CIF:</h5>
                        <input type="text" class="form-control mb-2" value="<?= $pedido->proveedor->cif ?>" disabled>
                    </div>
                    <div class="col-4">
                        <h5>Dirección:</h5>
                        <input type="text" class="form-control mb-2"
                            value="<?= $pedido->proveedor->direccion_completa() ?>" disabled>
                    </div>
                    <div class="col-4">
                        <h5>Teléfono:</h5>
                        <input type="text" class="form-control mb-2" value="<?= $pedido->proveedor->telefono ?>"
                            disabled>
                    </div>
                    <div class="col-4">
                        <h5>Correo Electrónico:</h5>
                        <input type="text" class="form-control mb-2" value="<?= $pedido->proveedor->correo ?>" disabled>
                    </div>
                    <div class="col-4">
                        <h5>Contacto:</h5>
                        <input type="text" class="form-control mb-2" value="<?= $pedido->proveedor->contacto ?>"
                            disabled>
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
                        <select class="form-control mb-2" id="subconcepto" name="subconcepto" <?= $editable ? '' : 'disabled' ?>>
                            <option value="" disabled hidden>Selecciona una opción</option>
                            <?php
                            /** @var Subconcepto $s */
                            foreach ($subconceptos as $s) { ?>
                                <option value="<?= $s->id ?>" <?= $pedido->subconcepto->id == $s->id ? 'selected' : '' ?>>
                                    <?= $s->nombre ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <h5>Descripción de la solicitud:</h5>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" <?= $editable ? '' : 'disabled' ?>><?= $pedido->descripcion ?></textarea>
                    </div>
                </div>

                <div class="row mx-4 my-3">
                    <div class="col-6">
                    </div>
                    <div class="col-6">
                        <button id="botoncontinuar" class="btn btn-success float-end">Guardar</button>
                    </div>

                </div>
            </div>
        </form>
        <?php if (count($incidenciasActivas) > 0) { ?>
            <div class="widget-content widget-content-area mt-2 p-3">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 ">
                        <h1>Incidencias Activas:</h1>
                    </div>
                    <?php foreach ($incidenciasActivas as $incidencia) { ?>
                        <div class="col-12 mb-2 p-2 incidencia">
                            <form method="post">
                                <input type="hidden" name="action" value="incidencia">
                                <input type="hidden" name="id" value="<?= $incidencia->id ?>">
                                <h4>Fecha: <?= $incidencia->getFechaVisible() ?></h4>
                                <h5><?= $incidencia->descripcion ?></h5>
                                <button class="btn btn-success">Marcar como solucionada</button>
                                <?php if ($usuario->tipo == ADMIN) { ?>
                                    <a href="Incidencias/vereditar?id=<?= $incidencia->id ?>&pedido=<?= $pedido->id ?>"
                                        class="btn btn-primary">Editar</a>
                                <?php } ?>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (count($incidenciasResueltas) > 0) { ?>
            <div class="widget-content widget-content-area mt-2 p-3">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 ">
                        <h1>Incidencias Solucionadas:</h1>
                    </div>
                    <?php foreach ($incidenciasResueltas as $incidencia) { ?>
                        <div class="col-12 mb-2 p-2 incidencia">
                            <input type="hidden" name="id" value="<?= $incidencia->id ?>">
                            <div class="row">
                                <div class="col-6">
                                    <h4>Fecha: <?= $incidencia->getFechaVisible() ?></h4>
                                </div>
                                <div class="col-6">
                                    <h4>Fecha Solucionada: <?= $incidencia->getFechaSolucionVisible() ?></h4>
                                </div>
                            </div>
                            <h5><?= $incidencia->descripcion ?></h5>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
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
                        case BORRADOR: ?>
                            <?php if ($pedido->comprobacion_presupuestos()): ?>
                                <div class="col-12 mb-3" id="subirfacturadiv">
                                    <h5>Subir facturas:</h5>
                                    <div class="mb-2">
                                        <form id="subirFacturas" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="siguiente">
                                            <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                            <h5>Presupuesto Seleccionado:</h5>
                                            <input type="file" id="presupuesto" name="presupuesto1" accept="application/pdf">
                                            <h5>Presupuesto alternativo 1:</h5>
                                            <input type="file" id="presupuesto2" name="presupuesto2" accept="application/pdf">
                                            <h5>Presupuesto alternativo 2:</h5>
                                            <input type="file" id="presupuesto3" name="presupuesto3" accept="application/pdf">
                                            <h5>Anexo III, Anexo XV</h5>
                                            <p><a href="<?= BASE_URL ?>public/Anexos_Rellenar.pdf" download>Descargar</a></p>
                                            <input type="file" id="anexo" name="anexo" accept="application/pdf">
                                            <button class="btn btn-success float-end">Enviar</button><br>
                                        </form>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-12 mb-2" id="subirfacturadiv">
                                    <form id="subirFactura" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="siguiente">
                                        <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                        <h5>Presupuesto Seleccionado:</h5>
                                        <input type="file" id="presupuesto" name="presupuesto1" accept="application/pdf">
                                        <button class="btn btn-success float-end">Enviar</button><br>
                                    </form>
                                </div>
                            <?php endif; ?>
                            <?php break;
                        case PEN_VALI: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <form class="mb-2" id="seguir" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>">
                                    <input type="hidden" name="action" value="siguiente">
                                    <button class="btn btn-success float-end">Enviar Proveedor</button><br>
                                </form>
                            <?php } ?>
                            <?php break;
                        case PEN_PROV: ?>
                            <h5>Subir albarán:</h5>
                            <form class="mb-2" id="subirFacturas" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                <input type="file" id="albaran" name="albaran" accept="application/pdf">
                                <button class="btn btn-success float-end">Subir Albarán</button><br>
                            </form>
                            <?php break;
                        case PEN_FACT: ?>
                            <h5>Subir factura:</h5>
                            <form class="mb-2" id="subirFacturas" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                <input type="file" id="factura" name="factura" accept="application/pdf">
                                <button class="btn btn-success float-end">Subir factura</button><br>
                            </form>
                            <?php break;
                        case PEN_ARCH: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <form class="mb-2" id="seguir" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>">
                                    <input type="hidden" name="action" value="siguiente">
                                    <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                    <button class="btn btn-success float-end">Archivo</button><br>
                                </form>
                            <?php } ?>
                            <?php break;
                        default:
                            break;
                    } ?>
                    <a class="btn btn-warning"
                        href="<?= BASE_URL ?>Incidencias/vereditar?id=0&pedido=<?= $pedido->id ?>">Nueva Incidencia</a>
                    <button type="submit" form="editarForm" class="btn btn-light-success mr-a">Guardar</button>
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
            if ($pedido->estado->id == BORRADOR) {
                echo "<h5>Todavía no hay documentos subidos</h5>";
            } else {
                ?>
                <h5 class="mb-0">Presupuesto seleccionado</h5>
                <a target="_blank"
                    href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $presupuestos[0]->documento ?>">Ver
                    Presupuesto</a>
                <?php if ($pedido->comprobacion_presupuestos()) { ?>
                    <h5 class="mb-0 mt-2">Presupuesto alternativo 1</h5>
                    <a target="_blank"
                        href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $presupuestos[1]->documento ?>">Ver
                        Presupuesto</a>
                    <h5 class="mb-0 mt-2">Presupuesto alternativo 2</h5>
                    <a target="_blank"
                        href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $presupuestos[2]->documento ?>">Ver
                        Presupuesto</a>
                    <h5 class="mb-0 mt-2">Anexo III, Anexo XV</h5>
                    <a target="_blank"
                        href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pedido->anexo ?>">Ver
                        Anexos</a>

                <?php } ?>
                <?php if ($pedido->estado->id >= PEN_FACT) { ?>
                    <h5 class="mb-0 mt-2">Albarán</h5>
                    <a target="_blank"
                        href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pedido->albaran ?>">Ver
                        Albarán</a>
                <?php } ?>
                <?php if ($pedido->estado->id >= PEN_ARCH) { ?>
                    <h5 class="mb-0 mt-2">Factura</h5>
                    <a target="_blank"
                        href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pedido->factura ?>">Ver
                        Factura</a>
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

    var inicial = true;
    function filtrarProveedores() {
        var seleccionado = $('#servicio').val();

        $('#proveedor option').each(function () {
            var ts = $(this).data('ts');

            if (ts == seleccionado) {
                $(this).show().prop('disabled', false);
            } else {
                $(this).hide().prop('disabled', true);
            }
        });

        if (!inicial) {
            $('#proveedor').val(0);
        }

    }

    document.addEventListener('DOMContentLoaded', function () {
        $('#servicio').on('change', filtrarProveedores)
        filtrarProveedores();
        inicial = false;
    });
</script>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>