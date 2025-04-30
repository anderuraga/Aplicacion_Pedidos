<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Usuarios - ".($usuario->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 2; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <h1>Usuario: <?= $usuario->id == 0 ? 'Nuevo' : 'Editar' ?></h1>
            <form id="editarUsuario" class="mt-0" action="Usuarios/vereditar?id=<?= $usuario->id ?>"
                method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $usuario->id ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Nombre:</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombre" required value="<?= $usuario->nombre ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Correo:</h5>
                        <input type="text" class="form-control mb-2" placeholder="Correo" aria-label="correo"
                            name="correo" id="correo" required value="<?= $usuario->correo ?>">
                    </div>
                </div>
                <?php if($usuario->id == 0): ?>
                    <p>Al crear un usuario la contraseña se le enviará automáticamente al correo</p>
                <?php endif; ?>
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Departamentos:</h5>
                        <select class="form-control" id="departamentoEdit" name="departamento">
                            <option value="" disabled <?= $usuario->departamento->id == 0 ? 'selected' : '' ?>>Selecciona un
                                departamento</option>
                            <?php foreach ($departamentos as $d): ?>
                                <option value="<?= $d->id ?>" <?= $d->id == $usuario->departamento->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($d->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                

                <a href="<?= BASE_URL ?>Usuarios"
                    class="btn btn-secondary mt-2">Volver</a>

                <button type="submit"
                    class="btn btn-primary mt-2"><?= $usuario->id == 0 ? 'Crear' : 'Editar' ?></button>

            </form>
        </div>
    </div>
</div>


<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>