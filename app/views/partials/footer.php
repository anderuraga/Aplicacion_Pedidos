<!-- CONTENT AREA -->

</div>

</div>


</div>
<!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->


<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?= BASE_URL ?>static/plugins/src/global/vendors.min.js"></script>
<script src="<?= BASE_URL ?>static/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>static/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<script src="<?= BASE_URL ?>static/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="<?= BASE_URL ?>static/plugins/src/table/datatable/datatables.min.js"></script>
<script src="<?= BASE_URL ?>static/plugins/src/table/datatable/ellipsis.js"></script>
<script src="<?= BASE_URL ?>static/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>

<script src="<?= BASE_URL ?>static/plugins/src/flatpickr/flatpickr.js"></script>
<script src="<?= BASE_URL ?>static/plugins/src/flatpickr/es.js"></script>
<script src="<?= BASE_URL ?>static/plugins/src/input-mask/jquery.inputmask.bundle.min.js"></script>
<script src="<?= BASE_URL ?>static/plugins/src/formsave/jquery.formsaver.js"></script>

<script>
    flatpickr.localize(flatpickr.l10ns.es);
    var tabla = $('.tabla').DataTable({
        "dom": "<'dt--top-section' i <'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l B><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + "<'table-responsive'tr>" + "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        buttons: [{ extend: 'copy', text: 'Copiar' }, 'csv', 'excel', 'pdf', { extend: 'print', text: 'Imprimir' }],
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Página _PAGE_ de _PAGES_ un total de _TOTAL_ filas",
            "sInfoEmpty": "Página 0 de 0 páginas",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "info": "Mostrando _START_ de _END_ de un total de _TOTAL_ filas",
            "sEmptyTable": "Sin resultados"
        },
        order: [[<?= $target ?? '1' ?>, '<?= $order ?? "asc" ?>']],
        columnDefs: [
                {
                targets: ["_all"],
                render: $.fn.dataTable.render.ellipsis(40, true)
                },

            <?= $extraColumndef ?? '' ?>
        ],
        "stripeClasses": [],
        "lengthMenu": [
            7, 10, 20, 50
        ],
        "pageLength": 25,
        initComplete: function (settings, json) {
            $('.dt-button').each(function (index) {
                $(this).removeClass('dt-button').addClass('btn btn-outline-info');
            });
        }
    });

    window.addEventListener("beforeunload", function (event) {
        $(".formulario").saveForm();
    });

</script>
<!-- END PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


</body>

</html>