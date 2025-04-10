<!-- CONTENT AREA -->

</div>

</div>

<div class="footer-wrapper">
    <div class="footer-section f-section-2">
        <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-heart">
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
<script src="src/plugins/src/table/datatable/datatables.min.js"></script>
<script src="src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
<script src="src/layouts/horizontal-light-menu/loader.js"></script>


<script>
    let tabla = $('.tabla').DataTable({
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