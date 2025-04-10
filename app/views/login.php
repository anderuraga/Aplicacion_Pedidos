<?php require_once HOMEDIR.'/../app/helpers/url.php'; ?>
<?php require HOMEDIR.'/../app/views/partials/header.php' ?>

<?php require HOMEDIR.'/../app/views/partials/alert.php' ?>

<body class="form">


    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <form id="login">
                                <div class="row">
                                    <div id="logodiv">
                                        <img class="d-block mx-auto" src="src/assets/img/logo/EEM-logo-color.svg">
                                    </div>
                                    <div class="col-md-12 mb-1 mt-2">
                                        <h2>Iniciar Sesión</h2>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Correo electrónico</label>
                                            <input type="email" id="correo" name="correo" class="form-control"
                                                value="javier.gomez@emaginarte.com"
                                                placeholder="Correo electrónico">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label">Contraseña</label>
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control" id="contrasena"
                                                    name="contrasena" placeholder="Contraseña"
                                                    value="emaginarte!"
                                                    aria-describedby="button-addon2">
                                                <button class="btn btn-primary" type="button" id="button-addon2"
                                                    onclick="switch_passwordfield(this)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </button>
                                            </div>
                                            <p><a class="text" id="forgotlink" onclick="mostrarModal()">¿Contraseña
                                                    olvidada?</a></p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
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
    <!-- BEGIN FORGOT PASSWORD MODAL -->
    <div class="modal fade inputForm-modal" id="forgotpasswordmodal" tabindex="-1" role="dialog"
        aria-labelledby="forgotpasswordmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header" id="forgotpasswordmodalLabel">
                    <h5 class="modal-title">Contraseña Olvidada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Para cambiar la contraseña, escribe el correo electrónico de la cuenta asociada y se te enviará
                        un correo electrónico con los pasos a seguir.</p>
                    <form id="recuperarContraseña" class="mt-0">
                        <h5>Correo electrónico</h5>
                        <input type="email" class="form-control" placeholder="Correo electrónico" aria-label="Correo"
                            name="mail" id="mail" required>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-light-danger mt-2 mb-2 btn-no-effect"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button id="recuperarContraseñaSubmit" type="submit" form="recuperarContraseña"
                        class="btn btn-primary mt-2 mb-2 btn-no-effect">Cambiar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END FORGOT PASSWORD MODAL -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="src/jquery/jquery-3.7.1.min.js"></script>
    <script src="src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
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

        function mostrarModal() {
            $('#forgotpasswordmodal').modal('show');
        }

        $('#recuperarContraseña').submit(function (e) {
            e.preventDefault();

        });

        $('#login').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'Login/autenticar',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        // Login correcto → redirigir
                        window.location.href = 'Menu';
                    } else {
                        // Mostrar error con SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de servidor',
                        text: 'Algo salió mal. Intenta nuevamente.'
                    });
                }
            });
        });
    </script>

<?php require HOMEDIR.'/../app/views/partials/footer.php' ?>