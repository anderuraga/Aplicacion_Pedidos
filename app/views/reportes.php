<?php require_once __DIR__ .'/../helpers/url.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Reportes</title>
    <link rel="icon" type="image/x-icon" href="src/assets/img/logo/favicon.png" />
    <!-- ENABLE LOADERS -->
    <link href="layouts/horizontal-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="layouts/horizontal-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="layouts/horizontal-light-menu/loader.js"></script>
    <!-- /ENABLE LOADERS -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="layouts/horizontal-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="layouts/horizontal-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="src/assets/css/light/elements/alert.css">
    <link rel="stylesheet" type="text/css" href="src/assets/css/dark/elements/alert.css">

    <link href="src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css" />
    <link href="src/assets/css/dark/components/modal.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="src/plugins/src/sweetalerts2/sweetalerts2.css">


    <link rel="stylesheet" type="text/css" href="src/plugins/src/table/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="src/plugins/css/dark/table/datatable/dt-global_style.css">

    <link href="src/plugins/css/light/apex/custom-apexcharts.css" rel="stylesheet" type="text/css">
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

        .facturaDiv {
            border-radius: 10px;
            background-color: rgb(218, 218, 218);
        }
    </style>

</head>

<body class="layout-boxed">

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
        <?php $tab = 6;
        require __DIR__ . '/partials/topbar.php'; ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!-- CONTENT AREA -->
                    <div class="row layout-top-spacing">
                        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="row m-4">
                                        <h1>Reportes</h1>
                                        <h5>Año Contable:</h5>
                                        <div class="row">
                                            <div class="col-3">
                                                <select class="form-control mb-2" name="anio_contable"
                                                    id="anio_contable" required>
                                                    <option>2025</option>
                                                    <option>2024</option>
                                                    <option>2023</option>
                                                    <option>2022</option>
                                                </select>
                                            </div>
                                        </div>
                                        <h2>Facturas:</h2>
                                        <div class="alert alert-outline-warning alert-dismissible fade show mb-4"
                                            role="alert">
                                            <strong>Hay 30 facturas pendientes de pago (12.345,99€)</strong>
                                        </div>
                                        <div class="alert alert-outline-success alert-dismissible fade show mb-4"
                                            role="alert">
                                            <strong>Hay 5 facturas están finalizadas (45.888,99€)</strong>
                                        </div>
                                        <h2>Áreas de gastos:</h2>
                                        <table id="areasgastos" class="table table-striped dt-table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <td>id</td>
                                                    <td>Nombre</td>
                                                    <td>Gasto</td>
                                                    <td>Restante</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Eficiencia Energética</td>
                                                    <td>24.000,00€</td>
                                                    <td>16.000,00€</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Eq. Informática</td>
                                                    <td>14.000,00€</td>
                                                    <td>8.000,00€</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>FoL</td>
                                                    <td>5.000,00€</td>
                                                    <td>19.000,00€</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Gastos Generales</td>
                                                    <td>24.000,00€</td>
                                                    <td>16.000,00€</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h2>Proveedores:</h2>
                                        <h3>Equipos Informáticos</h3>
                                        <table id="proveedor_equipoInformatico"
                                            class="table table-striped dt-table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>CIF</th>
                                                    <th>Razón Social</th>
                                                    <th>Pedidos</th>
                                                    <th>Gasto</th>
                                                    <th>Incidencias</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>S5979803C</td>
                                                    <td>Ordenadores Ordenadorez S.L</td>
                                                    <td>4</td>
                                                    <td>16.000,99€/18.000,00€</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <td>P5441014G</td>
                                                    <td>Ernie Electronics</td>
                                                    <td>7</td>
                                                    <td>18.000,00€/18.000,00€</td>
                                                    <td>3</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h3>Material Oficina</h3>
                                        <table id="proveedor_MaterialOficina" class="table table-striped dt-table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>CIF</th>
                                                    <th>Razón Social</th>
                                                    <th>Pedidos</th>
                                                    <th>Gasto</th>
                                                    <th>Incidencias</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>W6785220B</td>
                                                    <td>Todo Oficinas</td>
                                                    <td>2</td>
                                                    <td>4.800,00€/18.000,00€</td>
                                                    <td>0</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
            <!--  END CONTENT AREA  -->

        </div>

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="src/plugins/src/global/vendors.min.js"></script>
    <script src="src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="layouts/horizontal-light-menu/app.js"></script>


    <script src="src/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="src/plugins/src/table/datatable/datatables.min.js"></script>
    <script src="src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
    <script>

        $('#proveedor_equipoInformatico').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l B><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + "<'table-responsive'tr>" + "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: ['csv', 'excel', 'pdf', { extend: 'print', text: 'Imprimir' }],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Página _PAGE_ de _PAGES_",
                "sInfoEmpty": "Página 0 de 0 páginas",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "info": "Mostrando _START_ de _END_ de un total de _TOTAL_ filas",
                "sEmptyTable": "Sin resultados"
            },
            order: [[0, 'desc']],

            "stripeClasses": [],
            "lengthMenu": [
                7, 10, 20, 50
            ],
            "pageLength": 10,
            initComplete: function (settings, json) {
                $('.dt-button').each(function (index) {
                    $(this).removeClass('dt-button').addClass('btn btn-outline-info');
                });
            }
        });

        $('#proveedor_MaterialOficina').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l B><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + "<'table-responsive'tr>" + "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: ['csv', 'excel', 'pdf', { extend: 'print', text: 'Imprimir' }],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Página _PAGE_ de _PAGES_",
                "sInfoEmpty": "Página 0 de 0 páginas",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "info": "Mostrando _START_ de _END_ de un total de _TOTAL_ filas",
                "sEmptyTable": "Sin resultados"
            },
            order: [[0, 'desc']],

            "stripeClasses": [],
            "lengthMenu": [
                7, 10, 20, 50
            ],
            "pageLength": 10,
            initComplete: function (settings, json) {
                $('.dt-button').each(function (index) {
                    $(this).removeClass('dt-button').addClass('btn btn-outline-info');
                });
            }
        });

        $('#areasgastos').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l B><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + "<'table-responsive'tr>" + "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: ['csv', 'excel', 'pdf', { extend: 'print', text: 'Imprimir' }],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Página _PAGE_ de _PAGES_",
                "sInfoEmpty": "Página 0 de 0 páginas",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "info": "Mostrando _START_ de _END_ de un total de _TOTAL_ filas",
                "sEmptyTable": "Sin resultados"
            },
            order: [[0, 'desc']],
            columnDefs: [
                {
                    target: 0,
                    visible: false,
                    searchable: false
                }
            ],
            "stripeClasses": [],
            "lengthMenu": [
                7, 10, 20, 50
            ],
            "pageLength": 10,
            initComplete: function (settings, json) {
                $('.dt-button').each(function (index) {
                    $(this).removeClass('dt-button').addClass('btn btn-outline-info');
                });
            }
        });
    </script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>

</html>