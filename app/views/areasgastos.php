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
                                    <button type="button" class="btn btn-primary mb-2 ms-2 me-4" data-bs-toggle="modal"
                                        data-bs-target="#nuevaAreaGastoModal">Nueva area de gastos</button>

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
                                                            <button type="button" data-id="<?= $a->id ?>"
                                                                data-nombre="<?= $a->nombre ?>"
                                                                data-departamento="<?= $a->departamento_id ?>"
                                                                onclick="editar(this)"
                                                                class="btn btn-primary">Editar</button>
                                                        </div>

                                                        <a href="AreasGastos/vereditar?id=<?= $a->id ?>" class="btn-group">Editar</a>

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
            <!-- Modal Nuevo Usuario -->
            <div class="modal fade inputForm-modal" id="nuevaAreaGastoModal" tabindex="-1" role="dialog"
                aria-labelledby="nuevaAreaGastoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <div class="modal-header" id="nuevoDepartamentoModalLabel">
                            <h5 class="modal-title">Crear nueva Area de Gastos
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
                            <form id="nuevaAreaGasto" class="mt-0">
                                <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                                    name="nombre" id="nombre" required>
                                <h5>Departamentos:</h5>
                                <select class="form-control" id="departamento" name="departamento">
                                    <option value="" disabled selected>Selecciona un departamento</option>
                                    <?php foreach ($departamentos as $d): ?>
                                        <option value="<?= $d->id ?>">
                                            <?= htmlspecialchars($d->nombre) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-light-danger mt-2 mb-2 btn-no-effect"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button id="submitButton" type="submit" form="nuevaAreaGasto"
                                class="btn btn-primary mt-2 mb-2 btn-no-effect">Crear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Editar Usuario -->
        <div class="modal fade inputForm-modal" id="editarDepartamentoModal" tabindex="-1" role="dialog"
            aria-labelledby="editarDepartamentoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header" id="editarDepartamentoModalLabel">
                        <h5 class="modal-title">Editar Area de Gasto
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
                        <form id="editarDepartamento" class="mt-0">
                            <input type="hidden" id="idedit" name="id">
                            <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                                name="nombre" id="nombreEdit" required>
                            <h5>Departamentos:</h5>
                            <select class="form-control" id="departamentoEdit" name="departamento">
                                <option value="" disabled selected>Selecciona un departamento</option>
                                <?php foreach ($departamentos as $d): ?>
                                    <option value="<?= $d->id ?>">
                                        <?= htmlspecialchars($d->nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="borrarUsuario()"
                            class="btn btn-danger mt-2 mb-2 btn-no-effect">Borrar</button>
                        <button type="submit" class="btn btn-light-danger mt-2 mb-2 btn-no-effect"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button id="submitButtonEdit" type="submit" form="editarDepartamento"
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

    <script src="layouts/horizontal-light-menu/loader.js"></script>


    <script>


        $('#editarDepartamento').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: 'AreasGastos/editar',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.resultado) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.mensaje
                        }).then(() => {
                            actualizarFilaArea($('#idedit').val(), $('#nombreEdit').val(),$('#departamentoEdit').val(),$('#departamentoEdit option:selected').text());
                            $('#editarDepartamentoModal').modal('hide');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.mensaje
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de servidor',
                        text: 'Ocurrió un error al procesar la solicitud.'
                    });
                }
            });
        })

        function editar(elemento) {
            $('#idedit').val($(elemento).data("id"));
            $('#nombreEdit').val($(elemento).data("nombre"));
            $('#departamentoEdit').val($(elemento).data("departamento"));
            $('#editarDepartamentoModal').modal('show');
        }

        $('#nuevaAreaGasto').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: 'AreasGastos/crear',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.resultado) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.mensaje
                        }).then(() => {
                            tabla.row.add([
                                response.id, $('#nombre').val(),
                                $("#departamento option:selected").text(),
                                "0€",
                                "0€",
                                "0€",
                                `
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" data-id="${response.id}"
                                        data-nombre="${$('#nombre').val()}"
                                        data-departamento="${$("#departamento").val()}" 
                                        onclick="editar(this)"
                                        class="btn btn-primary">Editar</button>
                                </div>
                                `
                            ]).draw();
                            $('#nuevaAreaGastoModal').modal('hide');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.mensaje
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de servidor',
                        text: 'Ocurrió un error al procesar la solicitud.'
                    });
                }
            });
        })

        $('#nuevaAreaGastoModal').on('hidden.bs.modal', function () {
            $('#newUser').trigger('reset');
            $('#submitButton').html('Crear');
        })

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

        function actualizarFilaArea(id, nuevoNombre,nuevoDepartamentoId, nuevoDepartamentoNombre) {
            let rowIndex;

            tabla.rows().every(function (rowIdx, tableLoop, rowLoop) {
                const data = this.data();
                if (data[0] == id) {
                    rowIndex = rowIdx;
                }
            });

            if (rowIndex !== undefined) {
                const data = tabla.row(rowIndex).data();

                
                data[1] = nuevoNombre;
                data[2] = nuevoDepartamentoNombre;

                const nuevoBoton = `
            <div class="btn-group" role="group">
                <button type="button"
                    data-id="${id}"
                    data-nombre="${nuevoNombre}"
                    data-departamento="${nuevoDepartamentoId}"
                    onclick="editar(this)"
                    class="btn btn-primary">
                    Editar
                </button>
            </div>
        `;

                data[6] = nuevoBoton;

                tabla.row(rowIndex).data(data).draw();
            }
        }

    </script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    
</body>

</html>