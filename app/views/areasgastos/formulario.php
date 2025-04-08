<?php require_once __DIR__ . '/../../helpers/url.php'; ?>

<?php require_once __DIR__ . '/../../views/partials/header.php'; ?>

<?php require __DIR__ . '/../../views/partials/navbar.php' ?>


<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container " id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>


    <?php
    $tab = 8;
    require __DIR__ . '/../../views/partials/topbar.php';
    ?>


    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="middle-content container-xxl p-0">

                <div class="row layout-top-spacing">

                    <?php require __DIR__ . '/../../views/partials/alert.php' ?>

                    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area p-3">
                                <h1>Area de Gastos: <?= $areaGasto->id == 0 ? 'Nueva' : 'Editar' ?></h1>
                                <?php //TODO funcionamiento de nueva area de gasto ?>
                                <form id="editarDepartamento" class="mt-0"
                                    action="AreasGastos/vereditar?id=<?= $areaGasto->id ?>" method="post">
                                    <input type="hidden" id="idedit" name="id" value="<?= $areaGasto->id ?>">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h5>Nombre:</h5>
                                            <input type="text" class="form-control mb-2" placeholder="Nombre"
                                                aria-label="nombre" name="nombre" id="nombreEdit" required
                                                value="<?= $areaGasto->nombre ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h5>Departamentos:</h5>
                                            <select class="form-control" id="departamentoEdit" name="departamento">
                                                <option value="" disabled <?= $_GET['id']==0 ? 'selected' : '' ?>>Selecciona un departamento</option>
                                                <?php foreach ($departamentos as $d): ?>
                                                    <option value="<?= $d->id ?>" <?= $d->id==$areaGasto->departamento_id ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($d->nombre) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2"><?= $areaGasto->id == 0 ? 'Crear' : 'Editar' ?></button>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>



</body>

</html>