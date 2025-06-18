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
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x close" data-bs-dismiss="alert">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
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
                        <a href="<?= BASE_URL ?>Pedidos" class="btn btn-secondary btn-outline mb-3">Volver</a>
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
                    <h2>Descargar Plantillas</h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 ">
                    <div class="mt-container mx-auto">
                        <ul class="lista_archivos">
                            <li><a href="<?= BASE_URL ?>public/liquidacion_gastos.pdf" download=""><svg width="25px"
                                        height="25px" viewBox="-4 0 40 40" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M25.6686 26.0962C25.1812 26.2401 24.4656 26.2563 23.6984 26.145C22.875 26.0256 22.0351 25.7739 21.2096 25.403C22.6817 25.1888 23.8237 25.2548 24.8005 25.6009C25.0319 25.6829 25.412 25.9021 25.6686 26.0962ZM17.4552 24.7459C17.3953 24.7622 17.3363 24.7776 17.2776 24.7939C16.8815 24.9017 16.4961 25.0069 16.1247 25.1005L15.6239 25.2275C14.6165 25.4824 13.5865 25.7428 12.5692 26.0529C12.9558 25.1206 13.315 24.178 13.6667 23.2564C13.9271 22.5742 14.193 21.8773 14.468 21.1894C14.6075 21.4198 14.7531 21.6503 14.9046 21.8814C15.5948 22.9326 16.4624 23.9045 17.4552 24.7459ZM14.8927 14.2326C14.958 15.383 14.7098 16.4897 14.3457 17.5514C13.8972 16.2386 13.6882 14.7889 14.2489 13.6185C14.3927 13.3185 14.5105 13.1581 14.5869 13.0744C14.7049 13.2566 14.8601 13.6642 14.8927 14.2326ZM9.63347 28.8054C9.38148 29.2562 9.12426 29.6782 8.86063 30.0767C8.22442 31.0355 7.18393 32.0621 6.64941 32.0621C6.59681 32.0621 6.53316 32.0536 6.44015 31.9554C6.38028 31.8926 6.37069 31.8476 6.37359 31.7862C6.39161 31.4337 6.85867 30.8059 7.53527 30.2238C8.14939 29.6957 8.84352 29.2262 9.63347 28.8054ZM27.3706 26.1461C27.2889 24.9719 25.3123 24.2186 25.2928 24.2116C24.5287 23.9407 23.6986 23.8091 22.7552 23.8091C21.7453 23.8091 20.6565 23.9552 19.2582 24.2819C18.014 23.3999 16.9392 22.2957 16.1362 21.0733C15.7816 20.5332 15.4628 19.9941 15.1849 19.4675C15.8633 17.8454 16.4742 16.1013 16.3632 14.1479C16.2737 12.5816 15.5674 11.5295 14.6069 11.5295C13.948 11.5295 13.3807 12.0175 12.9194 12.9813C12.0965 14.6987 12.3128 16.8962 13.562 19.5184C13.1121 20.5751 12.6941 21.6706 12.2895 22.7311C11.7861 24.0498 11.2674 25.4103 10.6828 26.7045C9.04334 27.3532 7.69648 28.1399 6.57402 29.1057C5.8387 29.7373 4.95223 30.7028 4.90163 31.7107C4.87693 32.1854 5.03969 32.6207 5.37044 32.9695C5.72183 33.3398 6.16329 33.5348 6.6487 33.5354C8.25189 33.5354 9.79489 31.3327 10.0876 30.8909C10.6767 30.0029 11.2281 29.0124 11.7684 27.8699C13.1292 27.3781 14.5794 27.011 15.985 26.6562L16.4884 26.5283C16.8668 26.4321 17.2601 26.3257 17.6635 26.2153C18.0904 26.0999 18.5296 25.9802 18.976 25.8665C20.4193 26.7844 21.9714 27.3831 23.4851 27.6028C24.7601 27.7883 25.8924 27.6807 26.6589 27.2811C27.3486 26.9219 27.3866 26.3676 27.3706 26.1461ZM30.4755 36.2428C30.4755 38.3932 28.5802 38.5258 28.1978 38.5301H3.74486C1.60224 38.5301 1.47322 36.6218 1.46913 36.2428L1.46884 3.75642C1.46884 1.6039 3.36763 1.4734 3.74457 1.46908H20.263L20.2718 1.4778V7.92396C20.2718 9.21763 21.0539 11.6669 24.0158 11.6669H30.4203L30.4753 11.7218L30.4755 36.2428ZM28.9572 10.1976H24.0169C21.8749 10.1976 21.7453 8.29969 21.7424 7.92417V2.95307L28.9572 10.1976ZM31.9447 36.2428V11.1157L21.7424 0.871022V0.823357H21.6936L20.8742 0H3.74491C2.44954 0 0 0.785336 0 3.75711V36.2435C0 37.5427 0.782956 40 3.74491 40H28.2001C29.4952 39.9997 31.9447 39.2143 31.9447 36.2428Z"
                                                fill="#EB5757"></path>
                                        </g>
                                    </svg>Liquidación de
                                    gastos</a></li>
                            <li><a href="<?= BASE_URL ?>public/ANEXO III CONTRATO MENOR.docx" download=""><svg
                                        width="25px" height="25px" viewBox="0 0 32 32"
                                        xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>file_type_word2</title>
                                            <path
                                                d="M18.536,2.323V4.868c3.4.019,7.12-.035,10.521.019a.783.783,0,0,1,.912.861c.054,6.266-.013,12.89.032,19.157-.02.4.009,1.118-.053,1.517-.079.509-.306.607-.817.676-.286.039-.764.034-1.045.047-2.792-.014-5.582-.011-8.374-.01l-1.175,0v2.547L2,27.133Q2,16,2,4.873L18.536,2.322"
                                                style="fill:#283c82"></path>
                                            <path
                                                d="M18.536,5.822h10.5V26.18h-10.5V23.635h8.27V22.363h-8.27v-1.59h8.27V19.5h-8.27v-1.59h8.27V16.637h-8.27v-1.59h8.27V13.774h-8.27v-1.59h8.27V10.911h-8.27V9.321h8.27V8.048h-8.27V5.822"
                                                style="fill:#fff"></path>
                                            <path
                                                d="M8.573,11.443c.6-.035,1.209-.06,1.813-.092.423,2.147.856,4.291,1.314,6.429.359-2.208.757-4.409,1.142-6.613.636-.022,1.272-.057,1.905-.1-.719,3.082-1.349,6.19-2.134,9.254-.531.277-1.326-.013-1.956.032-.423-2.106-.916-4.2-1.295-6.314C8.99,16.1,8.506,18.133,8.08,20.175q-.916-.048-1.839-.111c-.528-2.8-1.148-5.579-1.641-8.385.544-.025,1.091-.048,1.635-.067.328,2.026.7,4.043.986,6.072.448-2.08.907-4.161,1.352-6.241"
                                                style="fill:#fff"></path>
                                        </g>
                                    </svg>Anexo III -
                                    contrato menor</a></li>
                            <li><a href="<?= BASE_URL ?>public/anexo XV prestacion servcicios.pdf" download=""><svg
                                        width="25px" height="25px" viewBox="-4 0 40 40" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M25.6686 26.0962C25.1812 26.2401 24.4656 26.2563 23.6984 26.145C22.875 26.0256 22.0351 25.7739 21.2096 25.403C22.6817 25.1888 23.8237 25.2548 24.8005 25.6009C25.0319 25.6829 25.412 25.9021 25.6686 26.0962ZM17.4552 24.7459C17.3953 24.7622 17.3363 24.7776 17.2776 24.7939C16.8815 24.9017 16.4961 25.0069 16.1247 25.1005L15.6239 25.2275C14.6165 25.4824 13.5865 25.7428 12.5692 26.0529C12.9558 25.1206 13.315 24.178 13.6667 23.2564C13.9271 22.5742 14.193 21.8773 14.468 21.1894C14.6075 21.4198 14.7531 21.6503 14.9046 21.8814C15.5948 22.9326 16.4624 23.9045 17.4552 24.7459ZM14.8927 14.2326C14.958 15.383 14.7098 16.4897 14.3457 17.5514C13.8972 16.2386 13.6882 14.7889 14.2489 13.6185C14.3927 13.3185 14.5105 13.1581 14.5869 13.0744C14.7049 13.2566 14.8601 13.6642 14.8927 14.2326ZM9.63347 28.8054C9.38148 29.2562 9.12426 29.6782 8.86063 30.0767C8.22442 31.0355 7.18393 32.0621 6.64941 32.0621C6.59681 32.0621 6.53316 32.0536 6.44015 31.9554C6.38028 31.8926 6.37069 31.8476 6.37359 31.7862C6.39161 31.4337 6.85867 30.8059 7.53527 30.2238C8.14939 29.6957 8.84352 29.2262 9.63347 28.8054ZM27.3706 26.1461C27.2889 24.9719 25.3123 24.2186 25.2928 24.2116C24.5287 23.9407 23.6986 23.8091 22.7552 23.8091C21.7453 23.8091 20.6565 23.9552 19.2582 24.2819C18.014 23.3999 16.9392 22.2957 16.1362 21.0733C15.7816 20.5332 15.4628 19.9941 15.1849 19.4675C15.8633 17.8454 16.4742 16.1013 16.3632 14.1479C16.2737 12.5816 15.5674 11.5295 14.6069 11.5295C13.948 11.5295 13.3807 12.0175 12.9194 12.9813C12.0965 14.6987 12.3128 16.8962 13.562 19.5184C13.1121 20.5751 12.6941 21.6706 12.2895 22.7311C11.7861 24.0498 11.2674 25.4103 10.6828 26.7045C9.04334 27.3532 7.69648 28.1399 6.57402 29.1057C5.8387 29.7373 4.95223 30.7028 4.90163 31.7107C4.87693 32.1854 5.03969 32.6207 5.37044 32.9695C5.72183 33.3398 6.16329 33.5348 6.6487 33.5354C8.25189 33.5354 9.79489 31.3327 10.0876 30.8909C10.6767 30.0029 11.2281 29.0124 11.7684 27.8699C13.1292 27.3781 14.5794 27.011 15.985 26.6562L16.4884 26.5283C16.8668 26.4321 17.2601 26.3257 17.6635 26.2153C18.0904 26.0999 18.5296 25.9802 18.976 25.8665C20.4193 26.7844 21.9714 27.3831 23.4851 27.6028C24.7601 27.7883 25.8924 27.6807 26.6589 27.2811C27.3486 26.9219 27.3866 26.3676 27.3706 26.1461ZM30.4755 36.2428C30.4755 38.3932 28.5802 38.5258 28.1978 38.5301H3.74486C1.60224 38.5301 1.47322 36.6218 1.46913 36.2428L1.46884 3.75642C1.46884 1.6039 3.36763 1.4734 3.74457 1.46908H20.263L20.2718 1.4778V7.92396C20.2718 9.21763 21.0539 11.6669 24.0158 11.6669H30.4203L30.4753 11.7218L30.4755 36.2428ZM28.9572 10.1976H24.0169C21.8749 10.1976 21.7453 8.29969 21.7424 7.92417V2.95307L28.9572 10.1976ZM31.9447 36.2428V11.1157L21.7424 0.871022V0.823357H21.6936L20.8742 0H3.74491C2.44954 0 0 0.785336 0 3.75711V36.2435C0 37.5427 0.782956 40 3.74491 40H28.2001C29.4952 39.9997 31.9447 39.2143 31.9447 36.2428Z"
                                                fill="#EB5757"></path>
                                        </g>
                                    </svg>Anexo XV
                                    - prestación de servicios</a></li>
                            <li><a href="<?= BASE_URL ?>public/ALTA_TERCEROS.pdf" download=""><svg width="25px"
                                        height="25px" viewBox="-4 0 40 40" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M25.6686 26.0962C25.1812 26.2401 24.4656 26.2563 23.6984 26.145C22.875 26.0256 22.0351 25.7739 21.2096 25.403C22.6817 25.1888 23.8237 25.2548 24.8005 25.6009C25.0319 25.6829 25.412 25.9021 25.6686 26.0962ZM17.4552 24.7459C17.3953 24.7622 17.3363 24.7776 17.2776 24.7939C16.8815 24.9017 16.4961 25.0069 16.1247 25.1005L15.6239 25.2275C14.6165 25.4824 13.5865 25.7428 12.5692 26.0529C12.9558 25.1206 13.315 24.178 13.6667 23.2564C13.9271 22.5742 14.193 21.8773 14.468 21.1894C14.6075 21.4198 14.7531 21.6503 14.9046 21.8814C15.5948 22.9326 16.4624 23.9045 17.4552 24.7459ZM14.8927 14.2326C14.958 15.383 14.7098 16.4897 14.3457 17.5514C13.8972 16.2386 13.6882 14.7889 14.2489 13.6185C14.3927 13.3185 14.5105 13.1581 14.5869 13.0744C14.7049 13.2566 14.8601 13.6642 14.8927 14.2326ZM9.63347 28.8054C9.38148 29.2562 9.12426 29.6782 8.86063 30.0767C8.22442 31.0355 7.18393 32.0621 6.64941 32.0621C6.59681 32.0621 6.53316 32.0536 6.44015 31.9554C6.38028 31.8926 6.37069 31.8476 6.37359 31.7862C6.39161 31.4337 6.85867 30.8059 7.53527 30.2238C8.14939 29.6957 8.84352 29.2262 9.63347 28.8054ZM27.3706 26.1461C27.2889 24.9719 25.3123 24.2186 25.2928 24.2116C24.5287 23.9407 23.6986 23.8091 22.7552 23.8091C21.7453 23.8091 20.6565 23.9552 19.2582 24.2819C18.014 23.3999 16.9392 22.2957 16.1362 21.0733C15.7816 20.5332 15.4628 19.9941 15.1849 19.4675C15.8633 17.8454 16.4742 16.1013 16.3632 14.1479C16.2737 12.5816 15.5674 11.5295 14.6069 11.5295C13.948 11.5295 13.3807 12.0175 12.9194 12.9813C12.0965 14.6987 12.3128 16.8962 13.562 19.5184C13.1121 20.5751 12.6941 21.6706 12.2895 22.7311C11.7861 24.0498 11.2674 25.4103 10.6828 26.7045C9.04334 27.3532 7.69648 28.1399 6.57402 29.1057C5.8387 29.7373 4.95223 30.7028 4.90163 31.7107C4.87693 32.1854 5.03969 32.6207 5.37044 32.9695C5.72183 33.3398 6.16329 33.5348 6.6487 33.5354C8.25189 33.5354 9.79489 31.3327 10.0876 30.8909C10.6767 30.0029 11.2281 29.0124 11.7684 27.8699C13.1292 27.3781 14.5794 27.011 15.985 26.6562L16.4884 26.5283C16.8668 26.4321 17.2601 26.3257 17.6635 26.2153C18.0904 26.0999 18.5296 25.9802 18.976 25.8665C20.4193 26.7844 21.9714 27.3831 23.4851 27.6028C24.7601 27.7883 25.8924 27.6807 26.6589 27.2811C27.3486 26.9219 27.3866 26.3676 27.3706 26.1461ZM30.4755 36.2428C30.4755 38.3932 28.5802 38.5258 28.1978 38.5301H3.74486C1.60224 38.5301 1.47322 36.6218 1.46913 36.2428L1.46884 3.75642C1.46884 1.6039 3.36763 1.4734 3.74457 1.46908H20.263L20.2718 1.4778V7.92396C20.2718 9.21763 21.0539 11.6669 24.0158 11.6669H30.4203L30.4753 11.7218L30.4755 36.2428ZM28.9572 10.1976H24.0169C21.8749 10.1976 21.7453 8.29969 21.7424 7.92417V2.95307L28.9572 10.1976ZM31.9447 36.2428V11.1157L21.7424 0.871022V0.823357H21.6936L20.8742 0H3.74491C2.44954 0 0 0.785336 0 3.75711V36.2435C0 37.5427 0.782956 40 3.74491 40H28.2001C29.4952 39.9997 31.9447 39.2143 31.9447 36.2428Z"
                                                fill="#EB5757"></path>
                                        </g>
                                    </svg>Alta terceros</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            <form class="mb-2 formulario" id="subirFacturas" method="post"
                                action="Pedidos/vereditar?id=<?= $pedido->id ?>" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                <button class="btn btn-success float-end">Cambiar a P.Archivado</button><br>
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
    <!-- historial -->


    <div class="statbox widget box box-shadow mt-2">
        <div class="widget-content widget-content-area p-2">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h2>Documentos Adjuntos</h2>
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

                        <?php for ($i = 1; $i <= $budgetCount; $i++):
                            $pres = $presupuestos[$i - 1] ?? null;
                            ?>
                            <div class="mb-2">
                                <h5>Presupuesto <?= $i ?>:</h5>
                                <?php if ($pres && $pres->documento): ?>
                                    <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pres->documento ?>"
                                        target="_blank" class="ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg> Ver documento</a>
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
                                        target="_blank" class="ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg> Ver documento </a>
                                <?php endif; ?>
                                <input type="file" id="anexo" name="anexo" accept="application/pdf">
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <h5>Albarán:</h5>
                            <?php if ($albaran): ?>
                                <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $albaran ?>"
                                    target="_blank" class="ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg> Ver documento </a>
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
                                target="_blank" class="ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg> Ver factura </a>
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
                            <label for="factura"><i>Archivo factura
                                    <?= $pedido->factura->id != 0 ? '(reemplazará el actual)' : '' ?> *</i></label>
                            <input type="file" id="factura" name="factura" accept="application/pdf"
                                <?= $pedido->factura->id != 0 ? '' : 'required' ?>>

                        </div>

                        <button type="submit" class="btn btn-success float-end">Subir factura</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


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