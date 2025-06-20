<?php if (count($incidenciasActivas) > 0) { ?>
    <div id="activasAccordion" class="accordion mt-2">
        <div class="card">
            <div class="card-header" id="activasAccordionUnoHeadingUno">
                <section class="mb-0 mt-0">
                    <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#activasAccordionUno"
                        aria-expanded="false" aria-controls="activasAccordionUno">
                        <h2>Incidencias Activas:</h2>
                        <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg></div>
                    </div>
                </section>
            </div>
            <div id="activasAccordionUno" class="collapse" aria-labelledby="activasAccordionUnoHeadingUno"
                data-bs-parent="#activasAccordion" style="">
                <div class="card-body">
                    <?php foreach ($incidenciasActivas as $incidencia) { ?>
                        <div class="col-12 mb-2 p-2 incidencia">
                            <form method="post">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <input type="hidden" name="action" value="incidencia">
                                        <input type="hidden" name="id" value="<?= $incidencia->id ?>">
                                        <h5>Fecha: <span class="fecha_incidencia"><?= $incidencia->getFechaVisible() ?></span>
                                        </h5>
                                        <p>Descripción:</p>
                                        <h5 class="inci_desc"><?= $incidencia->descripcion ?></h5>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-success">Marcar como solucionada</button>
                                        <?php if ($usuario->tipo == ADMIN) { ?>
                                            <a href="Incidencias/vereditar?id=<?= $incidencia->id ?>&pedido=<?= $pedido->id ?>"
                                                class="btn btn-primary">Editar</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>