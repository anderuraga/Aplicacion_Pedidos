<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Inventario"; ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 11; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>


<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2">Inventario</h1>

            <table id="inventario" class="tabla table table-striped dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <?php if ($usuario->tipo = ADMIN) { ?>
                            <th>Departamento</th>
                        <?php } ?>
                        <th>Cantidad</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    /**
                     * @var Item $i
                     */
                    foreach ($items as $i): ?>
                        <tr>
                            <td><?= $i->id ?></td>
                            <td><?= htmlspecialchars($i->nombre) ?></td>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <td><?= $i->departamento->nombre ?></td>
                            <?php } ?>
                            <td><?= $i->cantidad ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Opciones">
                                    <a type="button" href="Inventario/vereditar?id=<?= $i->id ?>"
                                        class="btn btn-primary">Editar</a>

                                    <a href="Inventario/historial?id=<?= $i->id ?>" class="btn btn-primary">Historial</a>
                                    <a type="button" href="<?= BASE_URL ?>Inventario/movimiento?id=0&item=<?= $i->id ?>"

                                        class="btn btn-secondary">Entrada/Salida</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>