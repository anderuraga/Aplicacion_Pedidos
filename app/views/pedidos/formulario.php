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
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"
                data-bs-dismiss="alert">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <?php
}

$editable = false;
if ($usuario->tipo == ADMIN || $pedido->estado->id == BORRADOR || $pedido->estado->id == PEN_VALI) {
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
                        <a href="<?= BASE_URL ?>Pedidos" class="btn btn-volver btn-outline mb-3">Volver</a>
                        <h1>Resumen del pedido: <?= $pedido->referencia ?></h1>
                        <h2>Estado: <?= $pedido->estado->nombre ?></h2>
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
                        <input type="text" class="form-control mb-2" name="referencia"
                            value="<?= $pedido->referencia ?>" <?= $editable ? '' : 'disabled' ?> required>
                    </div>
                    <div class="col-4">
                        <h5>Fecha creación:</h5>
                        <input type="text" class="form-control mb-2 flatTime flatpickr-input" name="fechaCreacion"
                            value="<?= $pedido->fecha_creada ?>" <?= $editable ? '' : 'disabled' ?> required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <h5>Departamento:</h5>
                        <?php if ($usuario->tipo == ADMIN) { ?>
                            <select class="form-control" id="departamento" name="departamento" required>
                                <?php
                                /** @var Departamento $d */
                                foreach ($departamentos as $d) { ?>
                                    <option value="<?= $d->id ?>" <?= $d->id == $pedido->departamento->id ? 'selected' : '' ?>>
                                        <?= $d->nombre ?>
                                    </option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <input type="text" class="form-control mb-2" value="<?= $pedido->departamento->nombre ?>"
                                <?= $editable ? '' : 'disabled' ?> required>
                        <?php } ?>
                    </div>
                    <div class="col-4">
                        <h5>Usuario:</h5>
                        <?php if ($usuario->tipo == ADMIN) { ?>
                            <select class="form-control" id="usuario_id" name="usuario_id" required>
                                <?php
                                /** @var Usuario $u */
                                foreach ($usuarios as $u) { ?>
                                    <option value="<?= $u->id ?>" <?= $u->id == $pedido->usuario->id ? 'selected' : '' ?>>
                                        <?= $u->nombre ?>
                                    </option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <input type="text" class="form-control mb-2" value="<?= $pedido->usuario->nombre ?>" disabled>
                        <?php } ?>

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
        <?php require_once __DIR__ . '/_incidenciasAbiertas.php' ?>
        <?php require_once __DIR__ . '/_incidenciasSolucionadas.php' ?>
    </div><!-- Cierra statbox widget box box-shadow -->
</div> <!-- Cierra tableSimple -->
<div id="sideDiv" class="col-lg-4 col-12 layout-spacing">


    <?php require_once __DIR__ . '/_plantillas.php' ?>
    <!-- plnatillas documentos -->


    <div class="statbox widget box box-shadow mt-2">
        <div class="widget-content widget-content-area p-2">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 ">
                    <h2>Opciones</h2>
                    <?php switch ($pedido->estado->id) {
                        case BORRADOR: ?>
                            <form id="subirFactura" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                <button class="btn btn-success float-end">Enviar para validar por Administración</button><br>
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
                                <button class="btn btn-success float-end">Cambiar a P.Factura</button><br>
                            </form>
                            <?php break;
                        case PEN_FACT: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <form class="mb-2 formulario" id="subirFacturas" method="post"
                                    action="Pedidos/vereditar?id=<?= $pedido->id ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="siguiente">
                                    <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                    <button class="btn btn-success float-end">Cambiar a P.Archivado</button><br>
                                </form>
                            <?php } ?>
                            <?php break;
                        case PEN_ARCH: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <form class="mb-2" id="seguir" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>">
                                    <input type="hidden" name="action" value="siguiente">
                                    <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                    <a target="_blank" href="<?= BASE_URL ?>Pedidos/pdf/<?= $pedido->id ?>"
                                        class="btn btn-primary">Imprimir</a>
                                    <button class="btn btn-success float-end">Archivar</button><br>
                                </form>
                            <?php } ?>
                            <?php break;
                        case ARCHIVADO: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <a target="_blank" href="<?= BASE_URL ?>Pedidos/pdf/<?= $pedido->id ?>"
                                    class="btn btn-primary">Imprimir</a>
                            <?php } ?>
                            <?php break;
                        default:
                            break;
                    } ?>

                    <a class="btn btn-warning"
                        href="<?= BASE_URL ?>Incidencias/vereditar?id=0&pedido=<?= $pedido->id ?>">Nueva Incidencia</a>

                    <?php if ($usuario->tipo == ADMIN): ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#borrarModal">Eliminar</button>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>


    <?php require_once __DIR__ . '/_historial.php' ?>
    <!-- historial -->

    <?php require_once __DIR__ . '/_documentos.php' ?>


</div>
<?php
$nombreBorrar = "Pedido";
$idborrar = $pedido->id;
require __DIR__ . '/../partials/borrarmodal.php';
?>
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