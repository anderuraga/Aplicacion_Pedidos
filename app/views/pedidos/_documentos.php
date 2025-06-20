<div id="documentosAdjuntosAccordion" class="accordion mt-2">
    <div class="card">
        <div class="card-header" id="documentosAdjuntosAccordionUnoHeadingUno">
            <section class="mb-0 mt-0">
                <div role="menu" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#documentosAdjuntosAccordionUno" aria-expanded="false"
                    aria-controls="documentosAdjuntosAccordionUno">
                    <h3>Documentos Adjuntos</h3>
                    <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg></div>
                </div>
            </section>
        </div>
        <div id="documentosAdjuntosAccordionUno" class="collapse"
            aria-labelledby="documentosAdjuntosAccordionUnoHeadingUno" data-bs-parent="#documentosAdjuntosAccordion"
            style="">
            <div class="card-body">
                <div class="row">
                    <form id="documentos" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                        <input type="hidden" name="action" value="documentos">
                        <div class="col-12 mb-3" id="documentosDiv">
                            <?php
                            // Cargar documentos existentes
                            $presupuestos = $presupuestos ?? [];
                            $albaran = $pedido->albaran ?? null;
                            $anexo = $pedido->anexo ?? null;

                            // Determinar número de presupuestos
                            $budgetCount = $pedido->importe >= 1000 ? 3 : 1;
                            ?>

                            <?php for ($i = 1; $i <= $budgetCount; $i++):
                                $pres = $presupuestos[$i - 1] ?? null;
                                ?>
                                <div class="mb-2">
                                    <h5>Presupuesto <?= $i ?>:</h5>
                                    <?php if ($pres && $pres->documento): ?>
                                        <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pres->documento ?>"
                                            target="_blank" class="ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-file-text">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                                <polyline points="10 9 9 9 8 9"></polyline>
                                            </svg> Ver documento</a>
                                    <?php endif; ?>
                                    <?php if ($budgetCount > 1): ?>
                                        <label class="ms-2">
                                            <input type="radio" name="presupuesto_seleccionado" value="<?= $i ?>" <?= ($pres && $pres->seleccionado == 1) ? 'checked' : '' ?>> Seleccionado
                                        </label>
                                    <?php endif; ?>
                                    <?php if ($pres && $pres->documento): ?>
                                        <input type="hidden" name="presupuesto<?= $i ?>_current" value="<?= $pres->id ?>">
                                    <?php endif; ?>
                                    <input type="file" id="presupuesto<?= $i ?>" name="presupuesto<?= $i ?>"
                                        accept="application/pdf">
                                </div>
                            <?php endfor; ?>

                            <?php if ($pedido->importe >= 1000): ?>
                                <div class="mb-3">
                                    <h5>Anexo:</h5>
                                    <?php if ($anexo): ?>
                                        <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $anexo ?>"
                                            target="_blank" class="ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-file-text">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                                <polyline points="10 9 9 9 8 9"></polyline>
                                            </svg> Ver documento </a>
                                    <?php endif; ?>
                                    <input type="file" id="anexo" name="anexo" accept="application/pdf">
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <h5>Albarán:</h5>
                                <?php if ($albaran): ?>
                                    <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $albaran ?>"
                                        target="_blank" class="ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-file-text">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg> Ver documento </a>
                                <?php endif; ?>
                                <input type="file" id="albaran" name="albaran" accept="application/pdf">

                            </div>

                            <button type="submit" class="btn btn-success float-end">Guardar documentos</button>
                        </div>
                    </form>


                    <div class="col-12 mb-3" id="facturaDiv">
                        <h5>Factura:</h5>
                        <form class="mb-2 formulario" id="subirFactura" method="post"
                            action="Pedidos/vereditar?id=<?= $pedido->id ?>" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="subir_factura">
                            <input type="hidden" name="id" value="<?= $pedido->id ?>">
                            <?php if (isset($pedido->factura) && $pedido->factura->id != 0): ?>
                                <a href="<?= BASE_URL ?>public/uploads/presupuestos/<?= $pedido->id ?>/<?= $pedido->factura->documento ?>"
                                    target="_blank" class="ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg> Ver factura </a>
                            <?php endif; ?>
                            <div class="mb-2">
                                <label for="referencia">Número de factura *</label>
                                <input type="text" class="form-control" id="referencia" name="referencia"
                                    value="<?= $pedido->factura->referencia ?? '' ?>" required>
                            </div>

                            <div class="mb-2">
                                <label for="fecha_factura">Fecha de factura *</label>
                                <input type="date" class="form-control flatTime" id="fecha_factura" name="fecha_factura"
                                    value="<?= $pedido->factura->fecha ?? '' ?>" required>
                            </div>

                            <div class="mb-2">
                                <label for="factura"><i>Archivo factura
                                        <?= $pedido->factura->id != 0 ? '(reemplazará el actual)' : '' ?> *</i></label>
                                <input type="file" id="factura" name="factura" accept="application/pdf"
                                    <?= $pedido->factura->id != 0 ? '' : 'required' ?>>

                            </div>

                            <button type="submit" class="btn btn-success float-end">Subir factura</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>