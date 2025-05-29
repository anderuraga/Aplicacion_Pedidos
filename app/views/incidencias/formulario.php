<?php
/**
 * @var Incidencia $incidencia
 * @var Pedido $pedido
 */
?>
<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Incidencia - " . ($incidencia->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <h1>Incidencia: <?= $incidencia->id == 0 ? 'Nueva' : 'Editar' ?></h1>
            <form id="editarSubconcepto" class="mt-0"
                action="<?= BASE_URL ?>Incidencias/vereditar?id=<?= $incidencia->id ?>&pedido=<?= $pedido->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $incidencia->id ?>">
                <input type="hidden" id="idpedi" name="pedido" value="<?= $pedido->id ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Descripción:</h5>
                        <select name="opciones" id="opciones" class="form-control">
                            <option value="" disabled <?= $incidencia->id == 0 ? 'selected' : '' ?> hidden>Selecciona una opción</option>
                            <option>Referencia erronea en presupuestos</option>
                            <option>Importe erroneo</option>
                            <option>Area de gastos equivocada</option>
                            <option value=0 <?= $incidencia->id != 0 ? 'selected' : '' ?>>Otro</option>
                        </select>
                        <textarea <?= $incidencia->id == 0 ? 'style="display: none;"' : '' ?> class="form-control mt-2" id="descripcion" name="descripcion"
                            rows="3"
                            placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. In iaculis erat justo, ac cursus nibh."><?= $incidencia->descripcion ?></textarea>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>Pedidos/vereditar?id=<?= $pedido->id ?>"
                    class="btn btn-secondary mt-2">Volver</a>

                <button type="submit"
                    class="btn btn-primary mt-2"><?= $incidencia->id == 0 ? 'Crear' : 'Editar' ?></button>

            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $("#opciones").on("change", function () {
            if($("#opciones").val()==0){
                $('#descripcion').val('').show();
            }else{
                $('#descripcion').hide().val($('#opciones option:selected').html());
            }
        });
    });

</script>

<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>