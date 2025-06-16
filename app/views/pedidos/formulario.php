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
        <form id="editarForm" method="post" class="formulario" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <input type="hidden" name="action" value="editar">
            <div class="widget-content widget-content-area p-3">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 ">
                        <a href="<?= BASE_URL ?>Pedidos" class="btn btn-danger mb-3">Volver</a>
                        <h1>Resumen del pedido: <?= $pedido->referencia ?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <h5>Importe: *</h5>
                        <div class="input-group mb-2">
                            <input class="form-control" placeholder="Cantidad" aria-label="cantidad"
                                aria-describedby="basic-addon2" name="cantidad" id="cantidad"
                                value="<?= $pedido->cantidad_formato() ?>" <?= $editable ? '' : 'disabled' ?> required>
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
                        <h5>Area Gasto: *</h5>
                        <?php if ($usuario->tipo == ADMIN) { ?>
                            <select class="form-control" id="areagasto" name="areagasto" required>
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
                        <h5>Proveedor: *</h5>
                        <select class="form-control mb-2" id="proveedor" name="proveedor" <?= $editable ? '' : 'disabled' ?> required>
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
                        <h5>Subconcepto: *</h5>
                        <select class="form-control mb-2" id="subconcepto" name="subconcepto" <?= $editable ? '' : 'disabled' ?> required>
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
                        <h5>Descripción de la solicitud: *</h5>
                        <textarea required class="form-control" id="descripcion" name="descripcion" rows="3"
                            <?= $editable ? '' : 'disabled' ?>><?= $pedido->descripcion ?></textarea>
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
                            <form id="subirFactura" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                <button class="btn btn-success float-end">Enviar</button><br>
                            </form>
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
                            <form class="mb-2" id="subirFacturas" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                <button class="btn btn-success float-end">Enviar</button><br>
                            </form>
                            <?php break;
                        case PEN_FACT: ?>
                            <form class="mb-2 formulario" id="subirFacturas" method="post"
                                action="Pedidos/vereditar?id=<?= $pedido->id ?>" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                <button class="btn btn-success float-end">Enviar</button><br>
                            </form>
                            <?php break;
                        case PEN_ARCH: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <form class="mb-2" id="seguir" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>">
                                    <input type="hidden" name="action" value="siguiente">
                                    <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                    <button class="btn btn-success float-end">Archivar</button><br>
                                </form>
                            <?php } ?>
                            <?php break;
                        case ARCHIVADO: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <a target="_blank" href="<?= BASE_URL ?>Pedidos/pdf/<?= $pedido->id ?>"
                                    class="btn btn-success float-end">Imprimir</a>
                                <?php } ?>
                                <?php break;
                        default:
                            break;
                    } ?>
                        <?php if ($usuario->tipo == ADMIN): ?>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#borrarModal">Borrar</button>
                            <a class="btn btn-warning"
                                href="<?= BASE_URL ?>Incidencias/vereditar?id=0&pedido=<?= $pedido->id ?>">Nueva
                                Incidencia</a>
                            <button type="submit" form="editarForm" class="btn btn-light-success mr-a">Guardar</button>
                        <?php endif; ?>
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

            <div class="row">
                <form id="documentos" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                    <input type="hidden" name="action" value="documentos">
                    <div class="col-12 mb-3" id="documentosDiv">
                        <?php
                        // Cargar documentos existentes
                        $presupuestos = $presupuestos ?? [];
                        $albaran = $pedido->albaran ?? null;
                        $anexo = $pedido->anexo ?? null;

                        // Determinar número de presupuestos
                        $budgetCount = $pedido->importe >= 1000 ? 3 : 1;
                        ?>

                        <h4>Presupuestos:</h4>
                        <?php for ($i = 1; $i <= $budgetCount; $i++):
                            $pres = $presupuestos[$i - 1] ?? null;
                            ?>
                            <div class="mb-2">
                                <h5>Presupuesto <?= $i ?></h5>
                                <?php if ($pres && $pres->documento): ?>
                                    <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pres->documento ?>"
                                        target="_blank" class="ms-2">Ver documento actual</a>
                                <?php endif; ?>
                                <?php if ($budgetCount > 1): ?>
                                    <label class="ms-2">
                                        <input type="radio" name="presupuesto_seleccionado" value="<?= $i ?>" <?= ($pres && $pres->seleccionado == 1) ? 'checked' : '' ?>> Seleccionado
                                    </label>
                                <?php endif; ?>
                                <?php if ($pres && $pres->documento): ?>
                                    <input type="hidden" name="presupuesto<?= $i ?>_current" value="<?= $pres->id ?>">
                                <?php endif; ?>
                                <input type="file" id="presupuesto<?= $i ?>" name="presupuesto<?= $i ?>"
                                    accept="application/pdf">
                            </div>
                        <?php endfor; ?>

                        <?php if ($pedido->importe >= 1000): ?>
                            <div class="mb-3">
                                <h5>Anexo:</h5>
                                <?php if ($anexo): ?>
                                    <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $anexo ?>"
                                        target="_blank" class="ms-2">Ver documento actual</a>
                                <?php endif; ?>
                                <input type="file" id="anexo" name="anexo" accept="application/pdf">
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <h5>Albarán:</h5>
                            <?php if ($albaran): ?>
                                <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $albaran ?>"
                                    target="_blank" class="ms-2">Ver documento actual</a>
                            <?php endif; ?>
                            <input type="file" id="albaran" name="albaran" accept="application/pdf">

                        </div>

                        <button type="submit" class="btn btn-success float-end">Guardar documentos</button>
                    </div>
                </form>


                <div class="col-12 mb-3" id="facturaDiv">
                    <h5>Factura:</h5>
                    <form class="mb-2 formulario" id="subirFactura" method="post"
                        action="Pedidos/vereditar?id=<?= $pedido->id ?>" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="subir_factura">
                        <input type="hidden" name="id" value="<?= $pedido->id ?>">
                        <?php if (isset($pedido->factura) && $pedido->factura->id != 0): ?>
                            <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pedido->factura->documento ?>"
                                target="_blank" class="ms-2">Ver factura actual</a>
                        <?php endif; ?>
                        <div class="mb-2">
                            <label for="referencia">Número de factura *</label>
                            <input type="text" class="form-control" id="referencia" name="referencia"
                                value="<?= $pedido->factura->referencia ?? '' ?>" required>
                        </div>

                        <div class="mb-2">
                            <label for="fecha_factura">Fecha de factura *</label>
                            <input type="date" class="form-control flatTime" id="fecha_factura" name="fecha_factura"
                                value="<?= $pedido->factura->fecha ?? '' ?>" required>
                        </div>

                        <div class="mb-2">
                            <label for="factura">Archivo factura
                                <?= isset($pedido->factura) ? '(reemplazará el actual)' : '' ?> *</label>
                            <input type="file" id="factura" name="factura" accept="application/pdf"
                                <?= isset($pedido->factura) ? '' : 'required' ?>>

                        </div>

                        <button type="submit" class="btn btn-success float-end">Subir factura</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="statbox widget box box-shadow mt-2">
        <div class="widget-content widget-content-area p-2">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h2>Descargas</h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 ">
                    <div class="mt-container mx-auto">
                        <ul class="lista_archivos">
                            <li><a href="<?= BASE_URL ?>public/liquidacion_gastos.pdf" download="">Liquidación de
                                    gastos</a></li>
                            <li><a href="<?= BASE_URL ?>public/ANEXO III CONTRATO MENOR.docx" download="">Anexo III -
                                    contrato menor</a></li>
                            <li><a href="<?= BASE_URL ?>public/anexo XV prestacion servcicios.pdf" download="">Anexo XV
                                    - prestación de servicios</a></li>
                            <li><a href="<?= BASE_URL ?>public/ALTA_TERCEROS.pdf" download="">Alta terceros</a></li>
                        </ul>
                    </div>
                </div>
            </div>
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
<div class="modal fade inputForm-modal" id="borrarModal" tabindex="-1" role="dialog"
    aria-labelledby="borrarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" id="borrarModalLabel">
                <h5 class="modal-title">Borrar Pedido
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
                    <input type="hidden" name="id" value="<?= $pedido->id ?>">
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

        $('.formulario').find('input:required, textarea:required').on('blur', function () {
            if ($.trim($(this).val()) === '') {
                $(this).addClass('required-vacio');
            } else {
                $(this).removeClass('required-vacio');
            }
        });

        let datepickers = $('.flatTime').flatpickr({
            altInput: true,
            altFormat: "d-m-Y",
            dateFormat: "Y-m-d",
        })
    });
</script>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>