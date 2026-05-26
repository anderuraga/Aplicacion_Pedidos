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

<div id="tableSimple" class="col-lg-8 col-12 layout-spacing proveedor_formulario">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area p-3">
            <a href="<?= BASE_URL ?>Proveedores" class="btn btn-volver mr-2 mb-3">
                Volver
            </a>
            
            <form action="<?= BASE_URL ?>Proveedores/solicitarDocumentos?id=0" method="GET" class="mb-3">
                <button type="submit" class="btn btn-primary">
                <i class="bi bi-envelope-fill me-2"></i>
                Enviar email al proveedor, solicitanto los documentos
                </button>
            </form>

            <h1>Proveedor: <?= $proveedor->id == 0 ? 'Nuevo' : 'Editar' ?></h1>


            <form id="nuevoProveedor" class="mt-0 formulario"
                action="<?= BASE_URL ?>Proveedores/vereditar?id=<?= $proveedor->id ?>" method="post"
                enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $proveedor->id ?>">
                <input type="hidden" name="action" value="guardar">
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
                        <h5>País: *</h5>
                        <input type="text" min="0" class="form-control mb-2" placeholder="País" aria-label="pais"
                            name="pais" id="pais" required value="<?= $proveedor->pais ?>">
                    </div>
                    <div class="col-6">
                        <h5>Teléfono: *</h5>
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
                        <input type="text" min="0" maxlength="32" class="form-control mb-2" placeholder="Cuenta bancaria máximo 32 caracteres"
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
                                value="<?= $proveedor->limite ?>">
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
               
                <!-- botones -->
                <div class="d-flex justify-content-between mt-2">
                    <?php if ($usuario->tipo == ADMIN): ?>
                        <button type="submit" form="estadoForm"
                            class="btn btn-<?= is_null($proveedor->fecha_baja) ? 'danger' : 'success' ?>">
                            <?= is_null($proveedor->fecha_baja) ? 'Dar de baja al proveedor' : 'Dar de Alta al proveedor' ?>
                        </button>
                    <?php endif; ?>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            Guardar
                        </button>
                    </div>
                </div>
                <!-- /botones -->

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
<!-- end tableSimple -->

<div id="sideDiv" class="col-lg-4 col-12 layout-spacing">

   <?php require HOMEDIR . '/../app/views/proveedores/_plantillas.php' ?>
   <?php require HOMEDIR . '/../app/views/proveedores/_documentos_subir.php' ?>
   <?php require HOMEDIR . '/../app/views/proveedores/_documentos.php' ?>

</div>
<!-- #sideDiv -->


<!-- modal -->

<?php
$nombreBorrar = "Proveedor";
$idborrar = $proveedor->id;
require __DIR__ . '/../partials/borrarmodal.php';
?>
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