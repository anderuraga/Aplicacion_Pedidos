<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Pedidos" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-8 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h1>Resumen del pedido</h1>
                    <a href="<?= recurso('Pedidos.php') ?>" class="btn btn-danger">Volver</a>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col-4">
                    <h5>Importe:</h5>
                    <input type="text" class="form-control mb-2" value="1.300,00€" disabled>
                </div>
                <div class="col-4">
                    <h5>Referencia:</h5>
                    <input type="text" class="form-control mb-2" value="00-07032025-123" disabled>
                </div>
                <div class="col-4">
                    <h5>Fecha:</h5>
                    <input type="text" class="form-control mb-2" value="07/03/2025" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <h5>Departamento:</h5>
                    <input type="text" class="form-control mb-2" value="Proyectos de Innovación" disabled>
                </div>
                <div class="col-4">
                    <h5>Usuario:</h5>
                    <input type="text" class="form-control mb-2" value="Ayman Lloren" disabled>
                </div>
                <div class="col-4">
                    <h5>Area Gasto:</h5>
                    <input type="text" class="form-control mb-2" value="Equipos Informáticos" disabled>
                </div>
            </div>
            <h4 class="mt-2">Proveedor: Ordenadores Ordenadorez S.L.</h4>
            <a id="detallesLink" onclick="toggleDetalles()">+ Mostrar Detalles</a>
            <div id="detallesProveedor" class="row p-3" style="display: none;">
                <div class="col-4">
                    <h5>CIF:</h5>
                    <input type="text" class="form-control mb-2" value="S5979803C" disabled>
                </div>
                <div class="col-4">
                    <h5>Dirección:</h5>
                    <input type="text" class="form-control mb-2" value="Calle Principal 12, 48902, Barakaldo, Bizkaia"
                        disabled>
                </div>
                <div class="col-4">
                    <h5>Teléfono:</h5>
                    <input type="text" class="form-control mb-2" value="612345789" disabled>
                </div>
                <div class="col-4">
                    <h5>Correo Electrónico:</h5>
                    <input type="text" class="form-control mb-2" value="ordenadores@ordenadorez.com" disabled>
                </div>
                <div class="col-4">
                    <h5>Servicio:</h5>
                    <input type="text" class="form-control mb-2" value="Equipos Informáticos" disabled>
                </div>
                <div class="col-4">
                    <h5>Factura electrónica:</h5>
                    <input type="text" class="form-control mb-2" value="Si" disabled>
                </div>
            </div>
            <h4 class="mt-2">Detalles:</h4>
            <div class="row">
                <div class="col-4">
                    <h5>Subconcepto:</h5>
                    <input type="text" class="form-control mb-2" value="(61400) Equipo Informatico" disabled>
                </div>
                <div class="col-4">
                    <h5>Tipo:</h5>
                    <input type="text" class="form-control mb-2" value="Inventariable Cap. VI" disabled>
                </div>

            </div>
            <div class="row">
                <div class="col-6">
                    <h5>Descripción de la solicitud:</h5>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                        disabled>Pedido de nuevos ordenadores para sustituir equipos antiguos.</textarea>
                </div>
            </div>

            <div id="incidenciasDiv" style="display:none;">
                <h4 class="mt-2">Incidencias:</h4>
                <h5>Incidencia registrada el 07/03/2025:</h5>
                <textarea class="form-control" name="descripcion" rows="3"
                    disabled>Los paquetes han venido dañados y la empresa dice que no se hace cargo</textarea>
            </div>
            <div class="row mx-4 my-3">
                <div class="col-6">
                </div>
                <div class="col-6">
                    <button id="botoncontinuar" class="btn btn-success float-end">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="sideDiv" class="col-lg-4 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h2>Estado: Pendiende de verificar</h2>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area pt-0">
            <div class="row mb-2">
                <div class="col-12 ">

                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#nuevaIncidenciaModal">Nueva Incidencia</button>
                    <button class="btn btn-light-success mr-a">Guardar</button><button
                        class="btn btn-success float-end">Verificar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="statbox widget box box-shadow mt-2">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h2>Documentos</h2>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area pt-0">
            <h4>Factura</h4>
            <div class="row mb-2">
                <div class="col-12" id="subirfacturadiv">
                    <h5>Subir factura:</h5>
                    <form id="subirFactura">
                        <input type="file" id="factura" name="factura" accept="application/pdf">
                        <button type="submit">Subir</button>
                    </form>
                </div>
                <div class="col-12" id="facturaSubidaDiv" style="display: none;">
                    <h5>Factura:</h5>
                    <h5><a href="<?= recurso('#') ?>">Ver archhivo</a></h5>
                </div>
            </div>
            <h4>Presupuesto/s</h4>
            <div class="row mb-2">
                <div class="col-12" id="subirPresupuestodiv">
                    <h5>Subir presupuesto:</h5>
                    <form id="subirPresupuesto">
                        <input type="file" id="presupuesto" name="presupuesto" accept="application/pdf">
                        <button type="submit">Subir</button>
                    </form>
                </div>
                <div class="col-12" id="presupuestoSubidoDiv" style="display: none;">
                    <h5>Presupuesto:</h5>
                    <h5><a href="<?= recurso('#') ?>">Ver archhivo</a></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="statbox widget box box-shadow mt-2">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h2>Historial</h2>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area pt-0">
            <div class="row mb-2">
                <div class="col-12 ">
                    <div class="mt-container mx-auto">
                        <div class="timeline-line">

                            <div class="item-timeline">
                                <p class="t-time">21/03/2025</p>
                                <div class="t-dot t-dot-warning">
                                </div>
                                <div class="t-text">
                                    <p>Nuevo estado: Pendiente de verificar</p>
                                    <p class="t-meta-time">12:30</p>
                                </div>
                            </div>

                            <div class="item-timeline">
                                <p class="t-time">21/03/2025</p>
                                <div class="t-dot t-dot-info">
                                </div>
                                <div class="t-text">
                                    <p>Factura subida</p>
                                    <p class="t-meta-time">12:10</p>
                                </div>
                            </div>

                            <div class="item-timeline">
                                <p class="t-time">21/03/2025</p>
                                <div class="t-dot t-dot-danger">
                                </div>
                                <div class="t-text">
                                    <p>Presupuesto subido</p>
                                    <p class="t-meta-time">12:05</p>
                                </div>
                            </div>

                            <div class="item-timeline">
                                <p class="t-time">21/03/2025</p>
                                <div class="t-dot t-dot-dark">
                                </div>
                                <div class="t-text">
                                    <p>Pedido creado</p>
                                    <p class="t-meta-time">12:00</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>