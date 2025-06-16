<?php
/**
 * @var Proveedor $proveedor
 */ ?>
<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Proveedor - " . ($proveedor->id == 0 ? 'Crear' : 'Editar'); ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 4; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing proveedor_formulario">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <a href="<?= BASE_URL ?>Proveedores" class="btn btn-secondary mr-2 mb-3">
                Volver
            </a>
            <h1>Proveedor: <?= $proveedor->id == 0 ? 'Nuevo' : 'Editar' ?></h1>


            <form id="nuevoProveedor" class="mt-0 formulario"
                action="<?= BASE_URL ?>Proveedores/vereditar?id=<?= $proveedor->id ?>" method="post"
                enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $proveedor->id ?>">
                <?php if ($proveedor->id != 0): ?>
                    <h5>Estado: <?= $proveedor->getEstado() ?></h5>
                    <div class="row">
                        <div class="col-4">
                            <h5>Usuario: <?= $proveedor->usuario->nombre ?></h5>
                        </div>
                        <div class="col-4">
                            <h5>Creado: <?= $proveedor->getFechaCreadoVisible() ?></h5>
                        </div>

                        <div class="col-4">
                            <h5>Editado: <?= $proveedor->getFechaEditadoVisible() ?></h5>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-6">
                        <h5>CIF: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="CIF" aria-label="cif" name="cif"
                            id="cif" required value="<?= $proveedor->cif ?>">
                    </div>
                    <div class="col-6">
                        <h5>Razón Social: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                            name="nombre" id="nombre" required value="<?= $proveedor->nombre ?>">
                    </div>
                    <div class="col-6">
                        <h5>Dirección: *</h5>
                        <input type="text" class="form-control mb-2" placeholder="Dirección" aria-label="direccion"
                            name="direccion" id="direccion" required value="<?= $proveedor->direccion ?>">
                    </div>
                    <div class="col-6">
                        <h5>Código postal: *</h5>
                        <input type="number" min="0" class="form-control mb-2" placeholder="Código Postal"
                            aria-label="codpostal" name="codpostal" id="codpostal" required
                            value="<?= $proveedor->cod_postal ?>">
                    </div>
                    <div class="col-6">
                        <h5>Población</h5>
                        <input type="text" min="0" class="form-control mb-2" placeholder="Población"
                            aria-label="poblacion" name="poblacion" id="poblacion" required
                            value="<?= $proveedor->poblacion ?>">
                    </div>
                    <div class="col-6">
                        <h5>Provincia: *</h5>
                        <input type="text" min="0" class="form-control mb-2" placeholder="Provincia"
                            aria-label="provincia" name="provincia" id="provincia" required
                            value="<?= $proveedor->provincia ?>">
                    </div>
                    <div class="col-6">
                        <h5>País</h5>
                        <input type="text" min="0" class="form-control mb-2" placeholder="País" aria-label="pais"
                            name="pais" id="pais" required value="<?= $proveedor->pais ?>">
                    </div>
                    <div class="col-6">
                        <h5>Teléfono</h5>
                        <input type="number" min="0" class="form-control mb-2" placeholder="Teléfono"
                            aria-label="telefono" name="telefono" id="telefono" required
                            value="<?= $proveedor->telefono ?>">
                    </div>
                    <div class="col-6">
                        <h5>Correo: *</h5>
                        <input type="email" class="form-control mb-2" placeholder="E-mail" name="mail" aria-label="mail"
                            name="mail" id="mail" required value="<?= $proveedor->correo ?>">
                    </div>
                    <div class="col-6">
                        <h5>Tipo de servicio: *</h5>
                        <select required id="tipoServicio" name="tipoServicio" class="form-control">
                            <option disabled="disabled" <?= $proveedor->id == 0 ? 'selected' : '' ?>>Tipo de Servicio
                            </option>
                            <?php foreach ($tiposservicio as $t) { ?>
                                <option value="<?= $t->id ?>" <?= $proveedor->tipo_servicio->id == $t->id ? 'selected' : '' ?>>
                                    <?= $t->nombre ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <h5>Cuenta bancaria: *</h5>
                        <input type="text" min="0" class="form-control mb-2" placeholder="Cuenta bancaria"
                            aria-label="cuenta_bancaria" name="cuenta_bancaria" id="cuenta_bancaria" required
                            value="<?= $proveedor->cuenta_bancaria ?>">
                    </div>
                    <div class="col-6">
                        <h5>Persona de contacto: *</h5>
                        <input type="text" min="0" class="form-control mb-2" placeholder="Persona contacto"
                            aria-label="contacto" name="contacto" id="contacto" required
                            value="<?= $proveedor->contacto ?>">
                    </div>
                    <div class="col-6">
                        <h5>Límite: *</h5>
                        <div class="input-group mb-2">
                            <input class="form-control" placeholder="Limite" aria-label="cantidad"
                                aria-describedby="basic-addon2" name="limite" id="limite"
                                value="<?= $proveedor->limite ?>" <?= $usuario->tipo != ADMIN ? 'disabled' : '' ?>>
                            <span class="input-group-text" id="basic-addon2">€</span>
                        </div>
                    </div>
                </div>

                <div class="form-check form-check-primary form-check-inline mt-2">
                    <input class="form-check-input" type="checkbox" id="facturaElectronica" name="facturaElectronica"
                        <?= $proveedor->factura_electronica ? 'checked' : '' ?>>
                    <label class="form-check-label" for="form-check-default">
                        Dispone de Factura Electrónica
                    </label>
                </div>
                <div class="separador mt-3 mb-3"></div>
                <h5><a href="<?= BASE_URL ?>public/ALTA_TERCEROS.pdf" download="">Descargar documento</a></h5>
                <div class="row">
                    <div class="col-6">
                        <h5>Alta terceros:</h5>
                        <?php if ($proveedor->terceros) { ?>
                            <a target="_blank"
                                href="<?= BASE_URL ?>public/uploads/proveedor/<?= $proveedor->id ?>/terceros/<?= $proveedor->terceros ?>">Ver
                                documento</a>
                            <p>Sustituir:</p>
                        <?php } else { ?>
                            <p>No hay documento subido. Subir:</p>
                        <?php } ?>
                        <input type="file" id="alta_terceros" name="alta_terceros" accept="application/pdf">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <?php if ($usuario->tipo == ADMIN): ?>
                        <button type="submit" form="estadoForm"
                            class="btn btn-<?= is_null($proveedor->fecha_baja) ? 'danger' : 'success' ?>">
                            <?= is_null($proveedor->fecha_baja) ? 'Baja' : 'Alta' ?>
                        </button>
                    <?php endif; ?>
                    <div>
                        <?php if ($usuario->tipo == ADMIN && $usuario->id != 0): ?>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#borrarModal">Borrar</button>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">
                            Guardar
                        </button>
                    </div>


                </div>

            </form>
            <?php if ($usuario->tipo == ADMIN): ?>
                <form id="estadoForm" method="post">
                    <input type="hidden" name="action" value="estado">
                    <input type="hidden" name="estado" value="<?= is_null($proveedor->fecha_baja) ? 'baja' : 'alta' ?>">
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="modal fade inputForm-modal" id="borrarModal" tabindex="-1" role="dialog"
    aria-labelledby="borrarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" id="borrarModalLabel">
                <h5 class="modal-title">Borrar Proveedor
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
                    <input type="hidden" name="id" value="<?= $proveedor->id ?>">
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
        $("#limite").inputmask("currency", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 2,
            autoGroup: true,
            prefix: ''
        });

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