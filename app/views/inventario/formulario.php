<?php
/**
 * @var Item $item
 */
?>
<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Inventario - Item " . ($item->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 11; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <h1>Item: <?= $item->id == 0 ? 'Nuevo' : 'Editar' ?></h1>
            <form id="editarDepartamento" class="mt-0" action="<?= BASE_URL ?>Inventario/vereditar?id=<?= $item->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $item->id ?>">

                <div class="row">
                    <div class="col-sm-4">
                        <?php if ($usuario->tipo == ADMIN) { ?>
                            <h5>Departamento:</h5>
                            <select class="form-control mb-2" id="departamento" name="departamento">
                                <option value="" disabled <?= $item->id==0?'selected':'' ?> hidden>Selecciona una opción</option>
                                <?php
                                /** @var Departamento $d */
                                foreach ($departamentos as $d) { ?>
                                    <option value="<?= $d->id ?>" <?= $item->departamento->id==$d->id?'selected':'' ?>><?= $d->nombre ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                        <h5>Nombre:</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombreEdit" required value="<?= $item->nombre ?>">
                    </div>
                </div>

                <a href="<?= BASE_URL ?>Inventario" class="btn btn-secondary mt-2">Volver</a>

                <button type="submit" class="btn btn-primary mt-2"><?= $item->id == 0 ? 'Crear' : 'Editar' ?></button>

            </form>
        </div>
    </div>
</div>

<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>