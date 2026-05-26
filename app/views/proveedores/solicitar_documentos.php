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
           <h1 class="mt-2 ms-2">Enviar Email al Proveedor</h1>
           <p class="p-3">Rellena el email del proveedor para que le envia un email solicitanto los documentos necesarios para darle de alta.</p>

           <div class="container mt-4">

            <form action="<?= BASE_URL ?>Proveedores/solicitarDocumentos" method="POST">

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope-fill me-1"></i>
                        Email
                    </label>

                    <input 
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="Introduce el email del proveedor"
                        required
                    >
                </div>

                <!-- Confirmar Email -->
                <div class="mb-3">
                    <label for="confirmar_email" class="form-label">
                        <i class="bi bi-envelope-check-fill me-1"></i>
                        Confirmar email
                    </label>

                    <input 
                        type="email"
                        class="form-control"
                        id="confirmar_email"
                        name="confirmar_email"
                        placeholder="Repite el email del proveedor"
                        required
                    >
                </div>

                <!-- Botón -->
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send-fill me-2"></i>
                    Enviar email
                </button>

            </form>

</div>
        </div>
    </div>
</div>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>