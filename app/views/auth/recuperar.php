<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Elorrieta - Recuperar Contraseña" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>

<body class="form">


    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <form id="recuperar" method="post">
                                <div class="row">
                                    <div id="logodiv">
                                        <img class="d-block mx-auto" src="<?= BASE_URL ?>static/assets/img/logo/EEM-logo-color.svg">
                                    </div>
                                    <div class="col-md-12 mb-1 mt-2">
                                        <h2>Recuperar contraseña</h2>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Correo electrónico</label>
                                            <input type="email" id="correo" name="correo" class="form-control"
                                                placeholder="Correo electrónico">
                                        </div>
                                        <p><a class="text" id="rememberlink" href="<?= BASE_URL ?>">Ir a inicio sesión</a></p>
                                    </div>
                                    <div class="col-12">
                                        <?php

                                        if (isset($_SESSION['alert'])) {

                                            ?>
                                            <div class="alert alert-<?= $_SESSION['alert']['tipo'] ?> alert-dismissible fade show"
                                                role="alert">
                                                <?= $_SESSION['alert']['mensaje'] ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>

                                            <?php
                                            unset($_SESSION['alert']);
                                        } ?>
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-primary w-100">Recuperar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- END FORGOT PASSWORD MODAL -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="static/jquery/jquery-3.7.1.min.js"></script>
    <script src="static/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="static/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
    <script>
        function switch_passwordfield(boton) {
            let inputfield = $(boton).parent().find("input");
            if (inputfield.attr('type') == "password") {
                inputfield.attr('type', "text");
                $(boton).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>');
            } else {
                inputfield.attr('type', "password");
                $(boton).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>');
            }
        }
    </script>

    <?php require HOMEDIR . '/../app/views/partials/footer.php' ?>