<?php
/**
 * @var Usuario $usuario_form
 */
?>
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
            <a href="<?= BASE_URL ?>Usuarios" class="btn btn-secondary mt-2 mb-3">Volver</a>
            <h1>Usuario: <?= $usuario_form->id == 0 ? 'Nuevo' : 'Editar' ?></h1>
            <form id="editarUsuario" class="mt-0 formulario"
                action="<?= BASE_URL ?>Usuarios/vereditar?id=<?= $usuario_form->id ?>" method="post">
                <input type="hidden" id="idedit" name="id" value="<?= $usuario_form->id ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Nombre: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombre" required value="<?= $usuario_form->nombre ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Correo: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Correo" aria-label="correo"
                            name="correo" id="correo" required value="<?= $usuario_form->correo ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?php if ($usuario_form->id == 0) { ?>
                            <h5>Contraseña: *</h5>
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
                        <h5>Tipo: *</h5>
                        <div class="form-check form-check-primary form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoEdit"
                                <?= $usuario_form->tipo == ADMIN ? 'checked' : '' ?> value="1" required>
                            <label class="form-check-label" for="form-check-radio-default">
                                Administrador
                            </label>
                        </div>
                        <div class="form-check form-check-primary form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoEdit"
                                <?= $usuario_form->tipo == JEFE_DEP || $usuario_form->id == 0 ? 'checked' : '' ?> value="0"
                                required>
                            <label class="form-check-label" for="tipo">
                                Jefe departamento
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Departamentos: *</h5>
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


                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ($usuario->tipo == ADMIN && $usuario->id != 0): ?>
                        <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#borrarModal">Borrar</button>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="modal fade inputForm-modal" id="borrarModal" tabindex="-1" role="dialog"
    aria-labelledby="borrarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" id="borrarModalLabel">
                <h5 class="modal-title">Borrar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form id="borrarForm" class="mt-0" method="post">
                    <input type="hidden" name="id" value="<?= $usuario_form->id ?>">
                    <input type="hidden" name="action" value="borrar">
                    <h5>Una vez borrado los datos no se podrán recuperar</h5>
                    <h5>Para confirmar la acción, escribe "Borrar" en el campo siguiente: </h5>
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
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('.formulario').find('input:required').on('blur', function () {
            if ($.trim($(this).val()) === '') {
                $(this).addClass('required-vacio');
            } else {
                $(this).removeClass('required-vacio');
            }
        });

        //$(".formulario").restoreForm();
    });
</script>

<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>