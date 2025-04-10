<?php require_once __DIR__ .'/../helpers/url.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Detalle: Gastos Generales</title>
    <link rel="icon" type="image/x-icon" href="<?= recurso('src/assets/img/logo/favicon.png') ?>" />
    <!-- ENABLE LOADERS -->
    <link href="<?= recurso('layouts/horizontal-light-menu/css/light/loader.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= recurso('layouts/horizontal-light-menu/css/dark/loader.css') ?>" rel="stylesheet" type="text/css" />
    <script src="<?= recurso('layouts/horizontal-light-menu/loader.js') ?>"></script>
    <!-- /ENABLE LOADERS -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="<?= recurso('https://fonts.googleapis.com/css?family=Nunito:400,600,700') ?>" rel="stylesheet">
    <link href="<?= recurso('src/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= recurso('layouts/horizontal-light-menu/css/light/plugins.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= recurso('layouts/horizontal-light-menu/css/dark/plugins.css') ?>" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="<?= recurso('src/assets/css/light/elements/alert.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= recurso('src/assets/css/dark/elements/alert.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= recurso('src/plugins/src/table/datatable/datatables.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= recurso('src/plugins/css/light/table/datatable/dt-global_style.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= recurso('src/plugins/css/dark/table/datatable/dt-global_style.css') ?>">

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

        .Ingreso {
            color: green !important;
        }

        .Gasto {
            color: red !important;
        }

        .dt-buttons {
            margin-left: 10px;
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
        <?php $tab = 8;
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
                                <div class="widget-content widget-content-area">
                                    <h1 class="mt-2 ms-2">Area de Gastos: <?= $area['nombre'] ?></h1>

                                    <table id="areasgastos" class="table table-striped dt-table-hover"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Fecha</th>
                                                <th>Descripción</th>
                                                <th>Operación</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
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
    <script src="<?= recurso('src/plugins/src/global/vendors.min.js') ?>"></script>
    <script src="<?= recurso('src/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= recurso('src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>

    <script src="<?= recurso('layouts/horizontal-light-menu/app.js') ?>"></script>


    <script src="<?= recurso('src/assets/js/custom.js') ?>"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="<?= recurso('src/plugins/src/flatpickr/flatpickr.js') ?>"></script>
    <script src="<?= recurso('src/plugins/src/table/datatable/datatables.min.js') ?>"></script>
    <script src="<?= recurso('src/plugins/src/sweetalerts2/sweetalerts2.min.js') ?>"></script>
    <script>
        let datepickers = $('.flatTime').flatpickr({
            enableTime: true,
            altInput: true,
            altFormat: "d-m-Y H:i",
            dateFormat: "Y-m-d H:i",
        })


        $('#nuevaTransaccion').on('submit', function (e) {
            e.preventDefault();
        })

        $('#nuevaTransaccionModal').on('hidden.bs.modal', function () {
            $('#newUser').trigger('reset');
            $('#submitButton').html('Crear');
        })

        $('#areasgastos').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l B><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + "<'table-responsive'tr>" + "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: [{extend:'copy',text:'Copiar'}, 'csv', 'excel', 'pdf', {extend:'print', text: 'Imprimir'}],
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
            order: [[1, 'desc']],
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
            ajax: '<?= recurso('Transacciones/listararea/'.$area['id']) ?>',
            columns: [
                { data: 'id' },
                {
                    data: {
                        _: "fecha_visisble",
                        sort: "fecha"
                    }
                },
                { data: 'descripcion' },
                { data: 'operacion'},
                {
                    data: null,
                    render: function (data, type, row) {
                        return `<span class="${row.operacion}">${row.cantidad}€</span>`;
                    }
                },
            ],
            initComplete: function (settings, json) {
                $('.dt-button').each(function (index){
                    $(this).removeClass('dt-button').addClass('btn btn-outline-info');
                });
            }
        });
    </script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>

</html>