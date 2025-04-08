<?php require_once __DIR__ .'/../helpers/url.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Subconceptos</title>
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
    <link rel="stylesheet" type="text/css" href="src/plugins/src/table/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="src/plugins/css/dark/table/datatable/dt-global_style.css">
    <link href="src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css" />
    <link href="src/assets/css/dark/components/modal.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="src/plugins/src/sweetalerts2/sweetalerts2.css">
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
    <?php require __DIR__.'/partials/navbar.php' ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php $tab = 7;
        require __DIR__.'/partials/topbar.php'; ?>
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
                                    <h1 class="mt-2 ms-2">Subconceptos</h1>
                                    <button type="button" class="btn btn-primary mb-2 ms-2 me-4" data-bs-toggle="modal"
                                        data-bs-target="#nuevoSubconceptoModal">Nuevo Subconcepto</button>
                                    <table id="subconceptos" class="table table-striped dt-table-hover"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Referencia</th>
                                                <th>Nombre</th>
                                                <th>Tipo</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>20400</td>
                                                <td>Arrendamiento de Maquinaria</td>
                                                <td>Fungible Cap. II</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" onclick="editar()"
                                                            class="btn btn-primary">Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>21100 </td>
                                                <td>Construcciones</td>
                                                <td>Fungible Cap. II </td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" onclick="editar()"
                                                            class="btn btn-primary">Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>61400</td>
                                                <td>Maquinaria</td>
                                                <td>Inventariable Cap. VI</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" onclick="editar()"
                                                            class="btn btn-primary">Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>61401</td>
                                                <td>Utillaje</td>
                                                <td>Inventariable Cap. VI</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" onclick="editar()"
                                                            class="btn btn-primary">Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
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
            <!-- Modal Nuevo Usuario -->
            <div class="modal fade inputForm-modal" id="nuevoSubconceptoModal" tabindex="-1" role="dialog"
                aria-labelledby="nuevoSubconceptoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <div class="modal-header" id="nuevoSubconceptoModalLabel">
                            <h5 class="modal-title">Crear nuevo Subconcepto
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
                            <form id="nuevoSubconcepto" class="mt-0">
                                <input type="number" class="form-control mb-2" placeholder="Referencia"
                                    aria-label="referencia" name="referencia" id="referencia" required>
                                <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                                    name="nombre" id="nombre" required>
                                <h5>Tipo:</h5>
                                <div class="form-check form-check-primary form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo" id="tipo">
                                    <label class="form-check-label" for="tipo">
                                        Fungible Cap. II
                                    </label>
                                </div>
                                <div class="form-check form-check-primary form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo" id="tipo">
                                    <label class="form-check-label" for="form-check-radio-default">
                                        Inventariable Cap. VI
                                    </label>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-light-danger mt-2 mb-2 btn-no-effect"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button id="submitButton" type="submit" form="newUser"
                                class="btn btn-primary mt-2 mb-2 btn-no-effect">Crear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Editar Usuario -->
        <div class="modal fade inputForm-modal" id="editarSubconceptoModal" tabindex="-1" role="dialog"
            aria-labelledby="editarSubconceptoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header" id="editarSubconceptoModalLabel">
                        <h5 class="modal-title">Editar Subconcepto
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
                        <form id="editarSubconcepto" class="mt-0">
                            <input type="number" class="form-control mb-2" placeholder="Referencia"
                                aria-label="referencia" name="referencia" id="referenciaEdit" required>
                            <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                                name="nombre" id="nombreEdit" required>
                            <h5>Tipo:</h5>
                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo" id="tipoEdit">
                                <label class="form-check-label" for="tipo">
                                    Fungible Cap. II
                                </label>
                            </div>
                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo" id="tipoEdit">
                                <label class="form-check-label" for="form-check-radio-default">
                                    Inventariable Cap. VI
                                </label>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="borrarUsuario()"
                            class="btn btn-danger mt-2 mb-2 btn-no-effect">Borrar</button>
                        <button type="submit" class="btn btn-light-danger mt-2 mb-2 btn-no-effect"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button id="submitButtonEdit" type="submit" form="edituser"
                            class="btn btn-primary mt-2 mb-2 btn-no-effect">Guardar</button>
                    </div>
                </div>
            </div>
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
    <script src="src/plugins/src/table/datatable/datatables.min.js"></script>
    <script src="src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
    <script>


        $('#editarSubconcepto').on('submit', function (e) {
            e.preventDefault();
        })

        function editar(id, nombre, active) {
            $('#editarSubconceptoModal').modal('show');
        }

        $('#nuevoSubconcepto').on('submit', function (e) {
            e.preventDefault();
        })

        $('#nuevoSubconceptoModal').on('hidden.bs.modal', function () {
            $('#newUser').trigger('reset');
            $('#submitButton').html('Crear');
        })

        $('#subconceptos').DataTable({
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
            "stripeClasses": [],
            "lengthMenu": [
                7, 10, 20, 50
            ],
            "pageLength": 10,
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