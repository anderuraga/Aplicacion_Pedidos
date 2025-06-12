<?php require_once __DIR__ .'/../helpers/url.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Proveedores</title>
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
    <link href="../src/assets/css/light/elements/tooltip.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/elements/tooltip.css" rel="stylesheet" type="text/css" />
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
        <?php $tab = 4;
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
                                    <h1 class="mt-2 ms-2">Proveedores</h1>
                                    <button type="button" class="btn btn-primary mb-2 ms-2 me-4" data-bs-toggle="modal"
                                        data-bs-target="#nuevoProveedorModal">Nuevo Proveedor</button>
                                    <table id="proveedores" class="table table-striped dt-table-hover"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>CIF</th>
                                                <th>Razón Social</th>
                                                <th>Dirección</th>
                                                <th title="Código Postal">C.P.</th>
                                                <th>Población</th>
                                                <th>Provincia</th>
                                                <th>Teléfono</th>
                                                <th>Correo</th>
                                                <th>Servicio</th>
                                                <th>F.E.</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>S5979803C</td>
                                                <td>Ordenadores Ordenadorez S.L.</td>
                                                <td>Calle Principal 12</td>
                                                <td>48902</td>
                                                <td>Barakaldo</td>
                                                <td>Bizkaia</td>
                                                <td>612345789</td>
                                                <td>ordenadores@ordenadorez.com</td>
                                                <td>Equipos Informáticos</td>
                                                <td>Si</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" onclick="editar()"
                                                            class="btn btn-primary">Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>W1845222G</td>
                                                <td>Somos Soldaduras</td>
                                                <td>La otra calle 23</td>
                                                <td>01001</td>
                                                <td>Vitoria-Gazteiz</td>
                                                <td>Alaba</td>
                                                <td>612345789</td>
                                                <td>somos@soldaduras.com</td>
                                                <td>Suministros Soldadura</td>
                                                <td>Si</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" onclick="editar()"
                                                            class="btn btn-primary">Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>W6785220B</td>
                                                <td>Todo Oficinas</td>
                                                <td>La otra otra calle 5</td>
                                                <td>20006</td>
                                                <td>Donostia</td>
                                                <td>Gipuzkoa</td>
                                                <td>612345789</td>
                                                <td>todo@oficinas.com</td>
                                                <td>Material de Oficina</td>
                                                <td>No</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" onclick="editar()"
                                                            class="btn btn-primary">Editar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>H13911193</td>
                                                <td>Desarrollos Gómez</td>
                                                <td>La otra otra calle 34</td>
                                                <td>39010</td>
                                                <td>Santander</td>
                                                <td>Cantabria</td>
                                                <td>612345789</td>
                                                <td>desarrollos@gomez.com</td>
                                                <td>Software</td>
                                                <td>Si</td>
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
            <div class="modal fade inputForm-modal" id="nuevoProveedorModal" tabindex="-1" role="dialog"
                aria-labelledby="nuevoProveedorModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">

                        <div class="modal-header" id="nuevoProveedorModalLabel">
                            <h5 class="modal-title">Añadir Proveedor
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
                            <form id="nuevoProveedor" class="mt-0">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control mb-2" placeholder="CIF" aria-label="cif"
                                            name="cif" id="cif" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control mb-2" placeholder="Nombre"
                                            aria-label="nombre" name="nombre" id="nombre" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control mb-2" placeholder="Dirección"
                                            aria-label="direccion" name="direccion" id="direccion" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="number" min="0" class="form-control mb-2"
                                            placeholder="Código Postal" aria-label="codpostal" name="codpostal"
                                            id="codpostal" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" min="0" class="form-control mb-2" placeholder="Población"
                                            aria-label="poblacion" name="poblacion" id="poblacion" required>
                                    </div>
                                    <div class="col-6">
                                        <select required id="provincia" name="provincia" class="form-control mb-2">
                                            <option selected="true" disabled="disabled">Provincia</option>
                                            <option value="Bizkaia">Bizkaia</option>
                                            <option value="Araba">Araba</option>
                                            <option value="Albacete">Albacete</option>
                                            <option value="Alicante">Alicante</option>
                                            <option value="Almería">Almería</option>
                                            <option value="Asturias">Asturias</option>
                                            <option value="Ávila">Ávila</option>
                                            <option value="Badajoz">Badajoz</option>
                                            <option value="Baleares">Baleares</option>
                                            <option value="Barcelona">Barcelona</option>
                                            <option value="Burgos">Burgos</option>
                                            <option value="Cáceres">Cáceres</option>
                                            <option value="Cádiz">Cádiz</option>
                                            <option value="Cantabria">Cantabria</option>
                                            <option value="Castellón">Castellón</option>
                                            <option value="Ceuta">Ceuta</option>
                                            <option value="Ciudad Real">Ciudad Real</option>
                                            <option value="Córdoba">Córdoba</option>
                                            <option value="Cuenca">Cuenca</option>
                                            <option value="Girona">Girona</option>
                                            <option value="Granada">Granada</option>
                                            <option value="Guadalajara">Guadalajara</option>
                                            <option value="Gipuzkoa">Gipuzkoa</option>
                                            <option value="Huelva">Huelva</option>
                                            <option value="Huesca">Huesca</option>
                                            <option value="Jaén">Jaén</option>
                                            <option value="A Coruña">A Coruña</option>
                                            <option value="La Rioja">La Rioja</option>
                                            <option value="Las Palmas">Las Palmas</option>
                                            <option value="León">León</option>
                                            <option value="Lleida">Lleida</option>
                                            <option value="Lugo">Lugo</option>
                                            <option value="Madrid">Madrid</option>
                                            <option value="Málaga">Málaga</option>
                                            <option value="Melilla">Melilla</option>
                                            <option value="Murcia">Murcia</option>
                                            <option value="Navarra">Navarra</option>
                                            <option value="Ourense">Ourense</option>
                                            <option value="Palencia">Palencia</option>
                                            <option value="Pontevedra">Pontevedra</option>
                                            <option value="Salamanca">Salamanca</option>
                                            <option value="Segovia">Segovia</option>
                                            <option value="Sevilla">Sevilla</option>
                                            <option value="Soria">Soria</option>
                                            <option value="Tarragona">Tarragona</option>
                                            <option value="Tenerife">Tenerife</option>
                                            <option value="Teruel">Teruel</option>
                                            <option value="Toledo">Toledo</option>
                                            <option value="Valencia">Valencia</option>
                                            <option value="Valladolid">Valladolid</option>
                                            <option value="Zamora">Zamora</option>
                                            <option value="Zaragoza">Zaragoza</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <input type="number" min="0" class="form-control" placeholder="Teléfono"
                                            aria-label="telefono" name="telefono" id="telefono" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="email" class="form-control mt-2 mb-2" placeholder="E-mail"
                                            aria-label="mail" name="mail" id="mail" required>
                                    </div>
                                    <div class="col-6">
                                        <select required id="tipoServicio" name="tipoServicio" class="form-control">
                                            <option selected="true" disabled="disabled">Tipo de Servicio</option>
                                            <option value="1">Equipos Informáticos</option>
                                            <option value="2">Material de Oficina</option>
                                            <option value="3">Suministros Soldadura</option>
                                            <option value="4">Software</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" min="0" class="form-control mb-2"
                                            placeholder="Cuenta bancaria" aria-label="poblacion" name="poblacion"
                                            id="cuenta_bancaria" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" min="0" class="form-control mb-2"
                                            placeholder="Persona contacto" aria-label="poblacion" name="poblacion"
                                            id="contacto" required>
                                    </div>
                                </div>

                                <div class="form-check form-check-primary form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" id="facturaElectronica"
                                        name="facturaElectronica">
                                    <label class="form-check-label" for="form-check-default">
                                        Dispone de Factura Electrónica
                                    </label>
                                </div>
                                <h5><a>Descargar documentos</a></h5>
                                <div class="row">
                                    <div class="col-6">
                                        <h5>Alta terceros</h5>
                                        <input type="file" id="alta_terceros" name="alta_terceros" accept="application/pdf">
                                    </div>
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
        $('#editarProveedor').on('submit', function (e) {
            e.preventDefault();
        })

        function editar(id, nombre, active) {
            $('#editarProveedorModal').modal('show');
        }

        $('#nuevoProveedor').on('submit', function (e) {
            e.preventDefault();
        })

        $('#nuevoProveedorModal').on('hidden.bs.modal', function () {
            $('#newUser').trigger('reset');
            $('#submitButton').html('Crear');
        })

        $('#proveedores').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l B><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + "<'table-responsive'tr>" + "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: [{ extend: 'copy', text: 'Copiar' }, 'csv', 'excel', 'pdf', { extend: 'print', text: 'Imprimir' }],
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
                $('.dt-button').each(function (index) {
                    $(this).removeClass('dt-button').addClass('btn btn-outline-info');
                });
            }
        });
    </script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>

</html>