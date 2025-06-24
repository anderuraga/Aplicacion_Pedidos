<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Menu" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 0 ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<?php
/**
 * @var Pedido[] $pedidosRevisar
 */
?>
<!-- CONTENT AREA -->
<div class="row layout-top-spacing">
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area p-3">
                <h1 class="mt-2 ">Bienvenido, <?= $usuario->nombre ?></h1>
                <?php
                $notificacion = false; ?>
                <?php if (count($pedidosIncidencias) > 0): ?>
                    <?php $notificacion = true; ?>
                    <div class="alert alert-icon-left alert-light-danger alert-dismissible fade show mb-4" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-alert-triangle">
                            <path
                                d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                            </path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        <strong>Aviso: </strong>Hay <strong><?= count($pedidosIncidencias) ?></strong> pedido(s)
                        pendiente(s)
                        con incidencias abiertas:
                        <ul>
                            <?php foreach ($pedidosIncidencias as $pedido): ?>
                                <li>
                                    <a href="<?= BASE_URL ?>Pedidos/vereditar?id=<?= $pedido[0]->id ?>"><?= $pedido[0]->referencia ?>
                                        (<?= $pedido[1] ?> incidencia(s))</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if ($usuario->tipo == ADMIN): ?>
                    <?php if (count($pedidosRevisar) > 0): ?>
                        <?php $notificacion = true; ?>
                        <div class="alert alert-icon-left alert-light-warning alert-dismissible fade show mb-4" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-alert-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12" y2="16"></line>
                            </svg>
                            <strong>Aviso: </strong>Hay <strong><?= count($pedidosRevisar) ?></strong> pedido(s) pendiente(s) de
                            revisión:
                            <ul>
                                <?php foreach ($pedidosRevisar as $pedido): ?>
                                    <li><a
                                            href="<?= BASE_URL ?>Pedidos/vereditar?id=<?= $pedido->id ?>"><?= $pedido->referencia ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if (count($pedidosArchivar) > 0): ?>
                        <?php $notificacion = true; ?>
                        <div class="alert alert-icon-left alert-light-success alert-dismissible fade show mb-4" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-package">
                                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <strong>Aviso: </strong>Hay <strong><?= count($pedidosArchivar) ?></strong> pedido(s) pendiente(s)
                            de ser archivados:
                            <ul>
                                <?php foreach ($pedidosArchivar as $pedido): ?>
                                    <li><a
                                            href="<?= BASE_URL ?>Pedidos/vereditar?id=<?= $pedido->id ?>"><?= $pedido->referencia ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php elseif ($usuario->tipo == JEFE_DEP): ?>
                    <?php if (count($pedidosProveedor) > 0): ?>
                        <?php $notificacion = true; ?>
                        <div class="alert alert-icon-left alert-light-warning alert-dismissible fade show mb-4" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-send">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                            <strong>Aviso: </strong>Hay <strong><?= count($pedidosProveedor) ?></strong> pedido(s) pendiente(s)
                            del proveedor:
                            <ul>
                                <?php foreach ($pedidosProveedor as $pedido): ?>
                                    <li>
                                        <a
                                            href="<?= BASE_URL ?>Pedidos/vereditar?id=<?= $pedido->id ?>"><?= $pedido->referencia ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if (count($pedidosFactura) > 0): ?>
                        <?php $notificacion = true; ?>
                        <div class="alert alert-icon-left alert-light-warning alert-dismissible fade show mb-4" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            <strong>Aviso: </strong>Hay <strong><?= count($pedidosFactura) ?></strong> pedido(s) pendiente(s)
                            de factura:
                            <ul>
                                <?php foreach ($pedidosFactura as $pedido): ?>
                                    <li><a
                                            href="<?= BASE_URL ?>Pedidos/vereditar?id=<?= $pedido->id ?>"><?= $pedido->referencia ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!$notificacion): ?>
                    <div class="alert alert-icon-left alert-light-success alert-dismissible fade show mb-4" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-check-circle">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        No hay ninguna notificación
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <!-- CONTENT AREA -->



    <?php require HOMEDIR . '/../app/views/partials/footer.php' ?>