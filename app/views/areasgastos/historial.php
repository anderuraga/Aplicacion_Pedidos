<?php
/**
 * @var AreaGastos $area
 */
?>
<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Area de Gastos - Historial" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 8; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div class="row layout-top-spacing">
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <a href="<?= BASE_URL ?>AreasGastos" class="btn btn-volver m-1">Volver</a>
                <h1 class="mt-2 ms-2">Area de Gastos: <?= $area->nombre ?></h1>

                <table id="areasgastos" class="tabla table table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <?php if ($usuario->tipo == ADMIN): ?> <th>Eliminar</th> <?php endif; ?>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Operación</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transacciones as $t): ?>
                            <tr>
                                <td><?= $t->id ?></td>
                                <?php if ($usuario->tipo == ADMIN): ?>
                                <td>
                                    <button type="button" class="btn p-0 border-0 bg-transparent"
                                            onclick="cambiarId(<?= $t->id ?>)"                                           
                                            data-bs-toggle="modal"
                                            data-bs-target="#borrarModal">
                                                <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </td>
                                <?php endif; ?>
                                <td data-sort="<?= $t->fecha ?>"><?= $t->getFechaVisible() ?></td>
                                <td><?= $t->descripcion ?></td>
                                <td><?= $t->getOperacion() ?></td>
                                <td><?= $t->cantidad_formato() ?>€</td>
                                <td><?= $t->total_formato() ?>€</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", () => {

        $('.formulario').find('input:required').on('blur', function () {
            if ($.trim($(this).val()) === '') {
                $(this).addClass('required-vacio');
            } else {
                $(this).removeClass('required-vacio');
            }
        });

    });   
    
    
        function cambiarId(id){
            console.debug('transaccion a eliminar ' + id);
            document.getElementById('delete_id').value = id;                           
        };

</script> 

<!-- modal -->
<div class="modal fade inputForm-modal" id="borrarModal" tabindex="-1" role="dialog"
    aria-labelledby="borrarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" id="borrarModalLabel">
                <h5 class="modal-title">Borrar Transacción
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="borrarForm" class="mt-0" method="post" action="<?= BASE_URL ?>AreasGastos/borrarTransaccion">
                    <input type="hidden" name="id" id="delete_id" value="-1">
                    <input type="hidden" name="idArea" value="<?=$area->id?>">
                    <input type="hidden" name="action" value="borrar">
                    <h5>Una vez borrado los datos no se podrán recuperar.</h5>
                    <h5>Para confirmar la acción, escribe el <b>"id"</b> de la transacción que quieres eliminar en el campo siguiente: </h5>
                    <input type="text" name="confirmacion" class="form-control">
                </form>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-light-primary mt-2 mb-2 btn-no-effect"
                    data-bs-dismiss="modal">Cancelar</button>
                <button id="submitButton" type="submit" form="borrarForm"
                    class="btn btn-danger mt-2 mb-2 btn-no-effect">Borrar</button>
            </div>
        </div>
    </div>
</div>





<?php
$order = 'desc'
?>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>