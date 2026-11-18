<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Cerrar Año Contable" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>
<?php require HOMEDIR . '/../app/views/partials/navbar.php' ?>
<?php $tab = 1; ?>
<?php require HOMEDIR . '/../app/views/partials/container.php' ?>
<?php require HOMEDIR . '/../app/views/partials/alert.php' ?>
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2"><?php echo $titulo?></h1>
            
            <div class="p-3">
                <p>CUIDADO: Al cerrar el año contable esta opción no tiene vuelta atras.</p>
                <p>Hablar con el responsable de informática y que realice una copia de seguridad.</p>
                <p>Todos los pedidos que no esten archivados se pasarán para el año proximo.</p>

                <a class="btn btn-danger mb-2 ms-2 me-4 float-center" href="<?= BASE_URL ?>Pedidos/inciarAnioContable">EJECUTAR PROCESO DE CERRAR AÑO CONTABLE</a>
            </div>
          
        </div>
    </div>
</div>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>