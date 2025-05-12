<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Pedido: Detalles" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<?php
/**
 * @var Departamento $departamento
 * @var AreaGastos $areagastos
 * @var Proveedor $proveedor
 */
?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <form method="post" action="Pedidos/detalles?proveedor=<?= $_GET['proveedor'] ?>&areaGasto=<?= $_GET['areaGasto'] ?>&departamento=<?= $_GET['departamento'] ?>">
            <input type="hidden" name="proveedor" value="<?= $_GET['proveedor'] ?>">
            <input type="hidden" name="areaGasto" value="<?= $_GET['areaGasto'] ?>">
            <input type="hidden" name="departamento" value="<?= $_GET['departamento'] ?>">
            <div class="widget-content widget-content-area ps-3">
                <h1 class="mt-2 ms-2">Pedido: Detalles</h1>
                <div class="row">
                    <div class="col-4">
                        <h4>Departamento:</h4>
                        <h5><?= $departamento->nombre ?></h5>
                    </div>
                    <div class="col-4">
                        <h4>Area gasto:</h4>
                        <h5><?= $areaGastos->nombre ?></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <h4>Proveedor:</h4>
                        <h5><?= $proveedor->nombre ?></h5>
                    </div>
                    <div class="col-4">
                        <h4>Gasto en año contable:</h4>
                        <h5><?= $proveedor->cantidad_formato() ?>€ / 18.000€</h5>
                    </div>
                </div>
                <h4 class="mt-2">Detalles:</h4>
                <div class="row">
                    <div class="col-4">
                        <h5>Subconcepto:</h5>
                        <select class="form-control" id="subconcepto" name="subconcepto">
                            <option value="" disabled selected hidden>Selecciona una opción</option>
                            <?php
                            /** @var Subconcepto $s */
                            foreach ($subconceptos as $s) { ?>
                                <option value="<?= $s->id ?>"><?= $s->nombre ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <h5>Importe:</h5>
                        <div class="input-group mb-2">
                            <input class="form-control" placeholder="Cantidad" aria-label="cantidad"
                                aria-describedby="basic-addon2" name="cantidad" id="cantidad">
                            <span class="input-group-text" id="basic-addon2">€</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h5>Descripción de la solicitud:</h5>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mx-4 my-1">
                    <div class="col-6">
                        <a href="<?= BASE_URL . "Pedidos/proveedor" ?>" class="btn btn-danger">Volver</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" id="botoncontinuar" class="btn btn-success float-end">Enviar</d>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $("#cantidad").inputmask("currency", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 2,
            autoGroup: true,
            prefix: ''
        });
    });
</script>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>