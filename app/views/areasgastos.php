<?php require_once __DIR__ . '/../helpers/url.php'; ?>

<?php require_once __DIR__ . '/../views/partials/header.php'; ?>
<?php require __DIR__ . '/../views/partials/loader.php' ?>
<?php require __DIR__ . '/../views/partials/navbar.php' ?>
 

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

      
        <?php 
            $tab = 8;
            require __DIR__ . '/../views/partials/topbar.php'; 
        ?>



        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">


                <div class="middle-content container-xxl p-0">

                    <!-- CONTENT AREA -->
                    <div class="row layout-top-spacing">

                    <?php require __DIR__ . '/../views/partials/alert.php' ?>


                        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <h1 class="mt-2 ms-2">Areas de Gastos</h1>
                                    <a href="AreasGastos/vereditar?id=0" class="btn btn-primary mb-2 ms-2 me-4">Nueva area de gastos</a>

                                    <table id="areasgastos" class="table table-striped dt-table-hover"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Nombre</th>
                                                <th>Departamento</th>
                                                <th>Ingresos</th>
                                                <th>Gastos</th>
                                                <th>Diferencia</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($areasGastos as $a): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($a->id) ?></td>
                                                    <td><?= htmlspecialchars($a->nombre) ?></td>
                                                    <td><?= htmlspecialchars($a->departamento_nombre) ?></td>
                                                    <td><?= $a->ingresos ?></td>
                                                    <td><?= $a->gastos ?></td>
                                                    <td><?= $a->diferencia ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="AreasGastos/vereditar?id=<?= $a->id ?>"
                                                                class="btn btn-primary">Editar</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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
    <?php // TODO Footer a un partial ?>                                            
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
    <script src="layouts/horizontal-light-menu/loader.js"></script>


    <script>
        let tabla = $('#areasgastos').DataTable({
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
            order: [[1, 'asc']],
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