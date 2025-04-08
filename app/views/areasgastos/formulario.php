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

                <div class="middle-content container-xxl p-0"></div>



                    <?php require __DIR__ . '/../../views/partials/alert.php' ?>



                                            <form id="editarDepartamento" class="mt-0" action="AreasGastos/vereditar?id=<?= $areaGasto->id ?>" method="post">
                                                <input type="hidden" id="idedit" name="id" value="<?= $areaGasto->id?>">
                                                <input type="text" class="form-control mb-2" placeholder="Nombre" aria-label="nombre"
                                                    name="nombre" id="nombreEdit" required value="<?= $areaGasto->nombre?>">>
                                                <h5>Departamentos:</h5>

                                                 <?php //TODO departamento seleccionado ?>
                                                <select class="form-control" id="departamentoEdit" name="departamento">
                                                    <option value="" disabled selected>Selecciona un departamento</option>
                                                    <?php foreach ($departamentos as $d): ?>
                                                        <option value="<?= $d->id ?>">
                                                            <?= htmlspecialchars($d->nombre) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>

                                                <input type="submit" value="EDITAR" />

                                            </form>

                                        </div>
                                      
                                </div>
                            </div>


    
    </body>

</html>       