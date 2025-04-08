<?php require_once __DIR__ . '/../helpers/url.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Nuevo Pedido</title>
    <link rel="icon" type="image/x-icon" href="<?= recurso('src/assets/img/logo/favicon.png') ?>" />
    <!-- ENABLE LOADERS -->
    <link href="<?= recurso('layouts/horizontal-light-menu/css/light/loader.css') ?>" rel="stylesheet"
        type="text/css" />
    <link href="<?= recurso('layouts/horizontal-light-menu/css/dark/loader.css') ?>" rel="stylesheet" type="text/css" />
    <script src="<?= recurso('layouts/horizontal-light-menu/loader.js') ?>"></script>
    <!-- /ENABLE LOADERS -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="<?= recurso('https://fonts.googleapis.com/css?family=Nunito:400,600,700') ?>" rel="stylesheet">
    <link href="<?= recurso('src/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= recurso('layouts/horizontal-light-menu/css/light/plugins.css') ?>" rel="stylesheet"
        type="text/css" />
    <link href="<?= recurso('layouts/horizontal-light-menu/css/dark/plugins.css') ?>" rel="stylesheet"
        type="text/css" />

    <link href="<?= recurso("src/assets/css/light/components/timeline.css") ?>" rel="stylesheet" type="text/css" />
    <link href="<?= recurso("src/assets/css/dark/components/timeline.css") ?>" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="<?= recurso('src/assets/css/light/elements/alert.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= recurso('src/assets/css/dark/elements/alert.css') ?>">
    <link href="<?= recurso('src/assets/css/light/components/modal.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= recurso('src/assets/css/dark/components/modal.css') ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= recurso('src/plugins/src/sweetalerts2/sweetalerts2.css') ?>">
    <link href="<?= recurso('src/plugins/src/flatpickr/flatpickr.css') ?>" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <style>
        body.dark .layout-px-spacing,
        .layout-px-spacing {
            min-height: calc(100vh - 155px) !important;
        }

        .nav-item.theme-logo {
            width: 120px;
        }

        .nav-item.theme-logo a {
            width: 100%;
        }

        .nav-item.theme-logo a img {
            max-width: 100%;
            max-height: 100%;
            width: auto !important;
        }

        #dt-length-0 {
            width: 65px !important;
        }

        h1,
        h4 {
            font-weight: bolder;
        }

        .form-control:disabled:not(.flatpickr-input) {
            color: black !important;
        }

        h5 a {
            font-weight: bolder;
            color: #3366ff;
        }

        h5 a:hover {
            font-weight: bolder;
            color: rgb(137, 167, 255);
        }

        #detallesProveedor {
            border: 2px solid lightgray;
            border-radius: 10px;
        }

        #detallesLink {
            cursor: pointer;
        }

        .item-timeline > .t-time {
            margin-right: 10px !important;
        }
    </style>

</head>

<body class="layout-boxed" layout="full-width">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <?php require __DIR__ . '/partials/navbar.php' ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php $tab = 1;
        require __DIR__ . '/partials/topbar.php'; ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!-- CONTENT AREA -->
                    <div class="row layout-top-spacing">
                        <div id="tableSimple" class="col-lg-8 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h1>Resumen del pedido</h1>
                                            <a href="<?= recurso('Pedidos.php') ?>" class="btn btn-danger">Volver</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="row">
                                        <div class="col-4">
                                            <h5>Importe:</h5>
                                            <input type="text" class="form-control mb-2" value="1.300,00€" disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Referencia:</h5>
                                            <input type="text" class="form-control mb-2" value="00-07032025-123"
                                                disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Fecha:</h5>
                                            <input type="text" class="form-control mb-2" value="07/03/2025" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <h5>Departamento:</h5>
                                            <input type="text" class="form-control mb-2" value="Proyectos de Innovación"
                                                disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Usuario:</h5>
                                            <input type="text" class="form-control mb-2" value="Ayman Lloren" disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Area Gasto:</h5>
                                            <input type="text" class="form-control mb-2" value="Equipos Informáticos"
                                                disabled>
                                        </div>
                                    </div>
                                    <h4 class="mt-2">Proveedor: Ordenadores Ordenadorez S.L.</h4>
                                    <a id="detallesLink" onclick="toggleDetalles()">+ Mostrar Detalles</a>
                                    <div id="detallesProveedor" class="row p-3" style="display: none;">
                                        <div class="col-4">
                                            <h5>CIF:</h5>
                                            <input type="text" class="form-control mb-2" value="S5979803C" disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Dirección:</h5>
                                            <input type="text" class="form-control mb-2"
                                                value="Calle Principal 12, 48902, Barakaldo, Bizkaia" disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Teléfono:</h5>
                                            <input type="text" class="form-control mb-2" value="612345789" disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Correo Electrónico:</h5>
                                            <input type="text" class="form-control mb-2"
                                                value="ordenadores@ordenadorez.com" disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Servicio:</h5>
                                            <input type="text" class="form-control mb-2" value="Equipos Informáticos"
                                                disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Factura electrónica:</h5>
                                            <input type="text" class="form-control mb-2" value="Si" disabled>
                                        </div>
                                    </div>
                                    <h4 class="mt-2">Detalles:</h4>
                                    <div class="row">
                                        <div class="col-4">
                                            <h5>Subconcepto:</h5>
                                            <input type="text" class="form-control mb-2"
                                                value="(61400) Equipo Informatico" disabled>
                                        </div>
                                        <div class="col-4">
                                            <h5>Tipo:</h5>
                                            <input type="text" class="form-control mb-2" value="Inventariable Cap. VI"
                                                disabled>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <h5>Descripción de la solicitud:</h5>
                                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                                disabled>Pedido de nuevos ordenadores para sustituir equipos antiguos.</textarea>
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
                                            <button id="botoncontinuar"
                                                class="btn btn-success float-end">Guardar</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="sideDiv" class="col-lg-4 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h2>Estado: Pendiende de verificar</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area pt-0">
                                    <div class="row mb-2">
                                        <div class="col-12 ">
                                            
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#nuevaIncidenciaModal">Nueva Incidencia</button>
                                            <button class="btn btn-light-success mr-a">Guardar</button><button
                                                class="btn btn-success float-end">Verificar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="statbox widget box box-shadow mt-2">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h2>Documentos</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area pt-0">
                                    <h4>Factura</h4>
                                    <div class="row mb-2">
                                        <div class="col-12" id="subirfacturadiv">
                                            <h5>Subir factura:</h5>
                                            <form id="subirFactura">
                                                <input type="file" id="factura" name="factura" accept="application/pdf">
                                                <button type="submit">Subir</button>
                                            </form>
                                        </div>
                                        <div class="col-12" id="facturaSubidaDiv" style="display: none;">
                                            <h5>Factura:</h5>
                                            <h5><a href="<?= recurso('#') ?>">Ver archhivo</a></h5>
                                        </div>
                                    </div>
                                    <h4>Presupuesto/s</h4>
                                    <div class="row mb-2">
                                        <div class="col-12" id="subirPresupuestodiv">
                                            <h5>Subir presupuesto:</h5>
                                            <form id="subirPresupuesto">
                                                <input type="file" id="presupuesto" name="presupuesto"
                                                    accept="application/pdf">
                                                <button type="submit">Subir</button>
                                            </form>
                                        </div>
                                        <div class="col-12" id="presupuestoSubidoDiv" style="display: none;">
                                            <h5>Presupuesto:</h5>
                                            <h5><a href="<?= recurso('#') ?>">Ver archhivo</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="statbox widget box box-shadow mt-2">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h2>Historial</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area pt-0">
                                    <div class="row mb-2">
                                        <div class="col-12 ">
                                            <div class="mt-container mx-auto">
                                                <div class="timeline-line">

                                                    <div class="item-timeline">
                                                        <p class="t-time">21/03/2025</p>
                                                        <div class="t-dot t-dot-warning">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Nuevo estado: Pendiente de verificar</p>
                                                            <p class="t-meta-time">12:30</p>
                                                        </div>
                                                    </div>

                                                    <div class="item-timeline">
                                                        <p class="t-time">21/03/2025</p>
                                                        <div class="t-dot t-dot-info">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Factura subida</p>
                                                            <p class="t-meta-time">12:10</p>
                                                        </div>
                                                    </div>

                                                    <div class="item-timeline">
                                                        <p class="t-time">21/03/2025</p>
                                                        <div class="t-dot t-dot-danger">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Presupuesto subido</p>
                                                            <p class="t-meta-time">12:05</p>
                                                        </div>
                                                    </div>

                                                    <div class="item-timeline">
                                                        <p class="t-time">21/03/2025</p>
                                                        <div class="t-dot t-dot-dark">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Pedido creado</p>
                                                            <p class="t-meta-time">12:00</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CONTENT AREA -->

                    </div>

                </div>

                <div class="footer-wrapper">
                    <div class="footer-section f-section-2">
                        <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg></p>
                    </div>
                </div>

            </div>
            <div class="modal fade inputForm-modal" id="nuevaIncidenciaModal" tabindex="-1" role="dialog"
                aria-labelledby="nuevaIncidenciaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <div class="modal-header" id="nuevaIncidenciaModalLabel">
                            <h5 class="modal-title">Nueva Incidencia
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="nuevaIncidencia" class="mt-0">
                                <input type="text" class="form-control flatTime mb-2" placeholder="Fecha"
                                    aria-label="fecha" name="fecha" id="fecha" required>
                                <h5>Descripción:</h5>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-light-danger mt-2 mb-2 btn-no-effect"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button id="submitButton" type="submit" form="nuevaIncidencia"
                                class="btn btn-primary mt-2 mb-2 btn-no-effect">Crear</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--  END CONTENT AREA  -->

        </div>

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?= recurso('src/plugins/src/global/vendors.min.js') ?>"></script>
    <script src="<?= recurso('src/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= recurso('src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
    <script src="<?= recurso('layouts/horizontal-light-menu/app.js') ?>"></script>

    <script src="<?= recurso('src/assets/js/custom.js') ?>"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="<?= recurso('src/plugins/src/sweetalerts2/sweetalerts2.min.js') ?>"></script>
    <script src="<?= recurso('src/plugins/src/flatpickr/flatpickr.js') ?>"></script>
    <script>
        function toggleDetalles() {
            $("#detallesProveedor").toggle();
        }

        let datepickers = $('.flatTime').flatpickr({
            altInput: true,
            altFormat: "d-m-Y",
            dateFormat: "Y-m-d",
        })

        $('#nuevaIncidencia').on('submit', function (e) {
            e.preventDefault();
            $('#incidenciasDiv').show();
            Swal.fire({
                title: "Se ha registrado la incidencia",
                icon: "success",
                focusConfirm: true,
                confirmButtonText: "Continuar",
            })
        })

        $('#nuevaIncidenciaModal').on('hidden.bs.modal', function () {
            $('#nuevaIncidencia').trigger('reset');
            $('#submitButton').html('Crear');
        })

        $('#subirFactura').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Factura adjuntada correctamente",
                icon: "success",
                focusConfirm: true,
                confirmButtonText: "Continuar",
            }).then((result) => {
                $('#subirfacturadiv').hide();
                $('#facturaSubidaDiv').show();
            });
        })

        $('#subirPresupuesto').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Presupuesto adjuntado correctamente",
                icon: "success",
                focusConfirm: true,
                confirmButtonText: "Continuar",
            }).then((result) => {
                $('#subirPresupuestodiv').hide();
                $('#presupuestoSubidoDiv').show();
            });
        })
    </script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>

</html>