<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Poveedores" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 4; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Proveedores</h1>
            <a href="<?= BASE_URL ?>Proveedores/vereditar?id=0" class="btn btn-primary mb-2 ms-2 me-4">Nuevo Proveedor</a>

            <table id="Proveedores" class="tabla table table-striped dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>CIF</th>
                        <th>Razón Social</th>
                        <th>Dirección</th>
                        <th title="Código Postal">C.P.</th>
                        <th>Población</th>
                        <th>Provincia</th>
                        <th>Servicio</th>
                        <th>F.E.</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proveedores as $p) { ?>
                        <tr>
                            <td><?= $p->id ?></td>
                            <td><?= $p->cif ?></td>
                            <td><?= $p->nombre ?></td>
                            <td><?= $p->direccion ?></td>
                            <td><?= $p->cod_postal ?></td>
                            <td><?= $p->poblacion ?></td>
                            <td><?= $p->provincia ?></td>
                            <td><?= $p->tipo_servicio->nombre ?></td>
                            <td><?= $p->factura_electronica ? 'Si' : 'No' ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="Proveedores/vereditar?id=<?= $p->id ?>" class="btn btn-primary">Editar</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>