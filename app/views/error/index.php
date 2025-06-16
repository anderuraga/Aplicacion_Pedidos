<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Elorrieta" ?>
<?php require HOMEDIR . '/../app/views/partials/header.php' ?>

<body class="form">


    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <form id="login" method="post">
                                <div class="row">
                                    <div class="col-md-12 mb-1 mt-2">
                                        <h1>Error: <?= $codigo ?></h1>
                                        <h5><?= $mensaje ?></h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <a href="<?= BASE_URL ?>" class="btn btn-primary w-100">Volver</a>
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


    <?php require HOMEDIR . '/../app/views/partials/footer.php' ?>