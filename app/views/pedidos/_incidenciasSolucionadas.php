<?php if (count($incidenciasResueltas) > 0) { ?>
    <div id="solucionadasAccordion" class="accordion mt-2">
        <div class="card">
            <div class="card-header" id="solucionadasAccordionUnoHeadingUno">
                <section class="mb-0 mt-0">
                    <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#solucionadasAccordionUno"
                        aria-expanded="false" aria-controls="solucionadasAccordionUno">
                        <h2>Incidencias Solucionadas:</h2>
                        <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg></div>
                    </div>
                </section>
            </div>
            <div id="solucionadasAccordionUno" class="collapse" aria-labelledby="solucionadasAccordionUnoHeadingUno"
                data-bs-parent="#solucionadasAccordion" style="">
                <div class="card-body">
                    <?php foreach ($incidenciasResueltas as $incidencia) { ?>
                        <div class="col-12 mb-2 p-2 incidencia">
                            <input type="hidden" name="id" value="<?= $incidencia->id ?>">
                            <div class="row">
                                <div class="col-6">
                                    <h4>Fecha: <?= $incidencia->getFechaVisible() ?></h4>
                                </div>
                                <div class="col-6">
                                    <h4>Fecha Solucionada: <?= $incidencia->getFechaSolucionVisible() ?></h4>
                                </div>
                            </div>
                            <h5><?= $incidencia->descripcion ?></h5>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>