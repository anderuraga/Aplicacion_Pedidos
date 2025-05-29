<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Usuarios - " . ($usuario_form->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 2; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>

<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <h1>Usuario: <?= $usuario_form->id == 0 ? 'Nuevo' : 'Editar' ?></h1>
            <form id="editarUsuario" class="mt-0" action="<?= BASE_URL ?>Usuarios/vereditar?id=<?= $usuario_form->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $usuario_form->id ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Nombre:</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombre" required value="<?= $usuario_form->nombre ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Correo:</h5>
                        <input type="text" class="form-control mb-2" placeholder="Correo" aria-label="correo"
                            name="correo" id="correo" required value="<?= $usuario_form->correo ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?php if ($usuario_form->id == 0) { ?>
                            <h5>Nueva Contraseña:</h5>
                        <?php } else { ?>
                            <h5>Cambiar contraseña:</h5>
                            <p>Dejar el campo en blanco para dejar la contraseña actual</p>
                        <?php } ?>
                        <input type="text" class="form-control mb-2" placeholder="Contraseña" aria-label="contrasena"
                            name="contrasena" id="contrasena" <?= $usuario_form->id == 0 ? 'required' : ''; ?>>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Tipo</h5>
                        <div class="form-check form-check-primary form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoEdit"
                                <?= $usuario_form->tipo == 1 ? 'checked' : '' ?> value="1">
                            <label class="form-check-label" for="form-check-radio-default">
                                Administrador
                            </label>
                        </div>
                        <div class="form-check form-check-primary form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoEdit"
                                <?= $usuario_form->tipo == 0 || $usuario_form->id == 0 ? 'checked' : '' ?> value="0">
                            <label class="form-check-label" for="tipo">
                                Jefe departamento
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Departamentos:</h5>
                        <select class="form-control" id="departamentoEdit" name="departamento">
                            <option value="" disabled <?= $usuario_form->id == 0 ? 'selected' : '' ?>>Selecciona un
                                departamento</option>
                            <?php foreach ($departamentos as $d): ?>
                                <option value="<?= $d->id ?>" <?= $d->id == $usuario_form->departamento->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($d->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


                <a href="<?= BASE_URL ?>Usuarios" class="btn btn-secondary mt-2">Volver</a>

                <button type="submit"
                    class="btn btn-primary mt-2"><?= $usuario_form->id == 0 ? 'Crear' : 'Editar' ?></button>

            </form>
        </div>
    </div>
</div>


<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>