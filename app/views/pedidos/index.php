<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Pedidos" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Pedidos</h1>
            <a class="btn btn-primary mb-2 ms-2 me-4" href="<?= BASE_URL ?>Pedidos/proveedor">Nuevo Pedido</a>

            <div class="simple-pill mt-3">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <?php foreach ($estados as $e) { ?>
                        <li class="nav-item" role="estado<?= $e->id ?>">
                            <button class="nav-link <?= $e->id == 1 ? 'active' : '' ?>" id="pills-estado<?= $e->id ?>-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-estado<?= $e->id ?>" type="button" role="tab"
                                aria-controls="pills-estado<?= $e->id ?>" aria-selected="false">
                                <?= $e->icono ?>
                                <?= $e->nombre . " (" . count($pedidos[$e->id]) . ")" ?>
                            </button>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <?php
                    /**
                     * @var Estado $e
                     */
                    foreach ($estados as $e) { ?>
                        <div class="tab-pane fade show <?= $e->id == 1 ? 'active' : '' ?>" id="pills-estado<?= $e->id ?>"
                            role="tabpanel" aria-labelledby="pills-estado<?= $e->id ?>-tab" tabindex="0">
                            <?php if ($usuario->tipo == ADMIN && $e->id == PEN_ARCH) { ?>
                                <form method="post">
                                    <button type="submit" class="btn btn-primary mb-2 ms-2 me-4">Archivar</button>
                                <?php } ?>
                                <table id="pedidos-estado<?= $e->id ?>"
                                    class="tabla table table-striped dt-table-hover pedidos-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Referencia</th>
                                            <?php if ($usuario->tipo == ADMIN && $e->id == PEN_ARCH) { ?>
                                                <th></th>
                                            <?php } ?>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                            <th>Departamento</th>
                                            <th>Area Gastos</th>
                                            <th>Subconcepto</th>
                                            <th>Proveedor</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        /** @var Pedido $p */
                                        foreach ($pedidos[$e->id] as $p) { ?>
                                            <tr>
                                                <td><?= $p->id ?></td>
                                                <td><?= $p->referencia ?></td>
                                                <?php if ($usuario->tipo == ADMIN && $e->id == PEN_ARCH) { ?>
                                                    <td>
                                                        <div class="form-check form-check-primary form-check-inline">
                                                            <input class="form-check-input proveedorRadio" type="checkbox"
                                                                name="pedidos[]" value="<?= $p->id ?>">
                                                        </div>
                                                    </td>
                                                <?php } ?>
                                                <td data-order="<?= $p->fecha_creada ?>"><?= $p->getFechaCreadaVisible() ?></td>
                                                <td><?= $p->cantidad_formato() ?>€</td>
                                                <td><?= $p->departamento->nombre ?></td>
                                                <td><?= $p->areaGastos->nombre ?></td>
                                                <td><?= $p->subconcepto->nombre ?></td>
                                                <td><?= $p->proveedor->nombre ?></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="<?= BASE_URL . "Pedidos/vereditar?id=" . $p->id ?>"
                                                            class="btn btn-primary">Ver</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                <?php if ($usuario->tipo == ADMIN && $e->id == PEN_ARCH) { ?>
                                </form>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>