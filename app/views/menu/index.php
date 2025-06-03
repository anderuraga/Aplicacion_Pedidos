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
                <?php if ($usuario->tipo == ADMIN): ?>
                    <?php if (count($pedidosRevisar) > 0): ?>
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
                <?php endif; ?>
            </div>

        </div>
    </div>
    <!-- CONTENT AREA -->



    <?php require HOMEDIR . '/../app/views/partials/footer.php' ?>