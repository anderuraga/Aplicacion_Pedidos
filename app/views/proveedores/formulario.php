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
                <h3>Documentación</h3>
                
                <div class="row">

                    <div class="col-4">
                        <p>                           
                            <a href="<?= BASE_URL ?>public/ALTA_TERCEROS.pdf" download=""><svg width="25px" height="64px" viewBox="-4 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M25.6686 26.0962C25.1812 26.2401 24.4656 26.2563 23.6984 26.145C22.875 26.0256 22.0351 25.7739 21.2096 25.403C22.6817 25.1888 23.8237 25.2548 24.8005 25.6009C25.0319 25.6829 25.412 25.9021 25.6686 26.0962ZM17.4552 24.7459C17.3953 24.7622 17.3363 24.7776 17.2776 24.7939C16.8815 24.9017 16.4961 25.0069 16.1247 25.1005L15.6239 25.2275C14.6165 25.4824 13.5865 25.7428 12.5692 26.0529C12.9558 25.1206 13.315 24.178 13.6667 23.2564C13.9271 22.5742 14.193 21.8773 14.468 21.1894C14.6075 21.4198 14.7531 21.6503 14.9046 21.8814C15.5948 22.9326 16.4624 23.9045 17.4552 24.7459ZM14.8927 14.2326C14.958 15.383 14.7098 16.4897 14.3457 17.5514C13.8972 16.2386 13.6882 14.7889 14.2489 13.6185C14.3927 13.3185 14.5105 13.1581 14.5869 13.0744C14.7049 13.2566 14.8601 13.6642 14.8927 14.2326ZM9.63347 28.8054C9.38148 29.2562 9.12426 29.6782 8.86063 30.0767C8.22442 31.0355 7.18393 32.0621 6.64941 32.0621C6.59681 32.0621 6.53316 32.0536 6.44015 31.9554C6.38028 31.8926 6.37069 31.8476 6.37359 31.7862C6.39161 31.4337 6.85867 30.8059 7.53527 30.2238C8.14939 29.6957 8.84352 29.2262 9.63347 28.8054ZM27.3706 26.1461C27.2889 24.9719 25.3123 24.2186 25.2928 24.2116C24.5287 23.9407 23.6986 23.8091 22.7552 23.8091C21.7453 23.8091 20.6565 23.9552 19.2582 24.2819C18.014 23.3999 16.9392 22.2957 16.1362 21.0733C15.7816 20.5332 15.4628 19.9941 15.1849 19.4675C15.8633 17.8454 16.4742 16.1013 16.3632 14.1479C16.2737 12.5816 15.5674 11.5295 14.6069 11.5295C13.948 11.5295 13.3807 12.0175 12.9194 12.9813C12.0965 14.6987 12.3128 16.8962 13.562 19.5184C13.1121 20.5751 12.6941 21.6706 12.2895 22.7311C11.7861 24.0498 11.2674 25.4103 10.6828 26.7045C9.04334 27.3532 7.69648 28.1399 6.57402 29.1057C5.8387 29.7373 4.95223 30.7028 4.90163 31.7107C4.87693 32.1854 5.03969 32.6207 5.37044 32.9695C5.72183 33.3398 6.16329 33.5348 6.6487 33.5354C8.25189 33.5354 9.79489 31.3327 10.0876 30.8909C10.6767 30.0029 11.2281 29.0124 11.7684 27.8699C13.1292 27.3781 14.5794 27.011 15.985 26.6562L16.4884 26.5283C16.8668 26.4321 17.2601 26.3257 17.6635 26.2153C18.0904 26.0999 18.5296 25.9802 18.976 25.8665C20.4193 26.7844 21.9714 27.3831 23.4851 27.6028C24.7601 27.7883 25.8924 27.6807 26.6589 27.2811C27.3486 26.9219 27.3866 26.3676 27.3706 26.1461ZM30.4755 36.2428C30.4755 38.3932 28.5802 38.5258 28.1978 38.5301H3.74486C1.60224 38.5301 1.47322 36.6218 1.46913 36.2428L1.46884 3.75642C1.46884 1.6039 3.36763 1.4734 3.74457 1.46908H20.263L20.2718 1.4778V7.92396C20.2718 9.21763 21.0539 11.6669 24.0158 11.6669H30.4203L30.4753 11.7218L30.4755 36.2428ZM28.9572 10.1976H24.0169C21.8749 10.1976 21.7453 8.29969 21.7424 7.92417V2.95307L28.9572 10.1976ZM31.9447 36.2428V11.1157L21.7424 0.871022V0.823357H21.6936L20.8742 0H3.74491C2.44954 0 0 0.785336 0 3.75711V36.2435C0 37.5427 0.782956 40 3.74491 40H28.2001C29.4952 39.9997 31.9447 39.2143 31.9447 36.2428Z" fill="#EB5757"></path> </g></svg>                    Descargar plantilla alta Terceros</a>
                        </p>
                    </div>

                    <div class="col-4">                     
                        <?php if ($proveedor->terceros) { ?>
                            <a target="_blank"
                                href="<?= BASE_URL ?>public/uploads/proveedor/<?= $proveedor->id ?>/terceros/<?= $proveedor->terceros ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>Ver
                                documento guardado</a>                            
                        <?php } else { ?>
                            <p>No hay documento guardado. Subir:</p>
                        <?php } ?>
                        
                    </div>
                    <div class="col-4">
                        <p><?= $proveedor->terceros ? 'Sustituir documento' : 'Guardar documento' ?></p>
                        <input type="file" id="alta_terceros" name="alta_terceros" accept="application/pdf">
                    </div>

                </div>

                <hr>
                <div class="d-flex justify-content-between mt-2">
                    <?php if ($usuario->tipo == ADMIN): ?>
                        <button type="submit" form="estadoForm"
                            class="btn btn-<?= is_null($proveedor->fecha_baja) ? 'danger' : 'success' ?>">
                            <?= is_null($proveedor->fecha_baja) ? 'Dar de baja al proveedor' : 'Dar de Alta al proveedor' ?>
                        </button>
                    <?php endif; ?>
                    <div>
                        <?php if ($usuario->tipo == ADMIN && $proveedor->id != 0): ?>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#borrarModal">Borrar</button>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">
                            Guardar
                        </button>
                    </div>


                </div>

            </form>


            <hr>
            <?php if ($usuario->tipo == ADMIN): ?>
                <form id="estadoForm" method="post">
                    <input type="hidden" name="action" value="estado">
                    <input type="hidden" name="estado" value="<?= is_null($proveedor->fecha_baja) ? 'baja' : 'alta' ?>">
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>


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