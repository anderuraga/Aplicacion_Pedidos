<div id="toggleAccordion" class="accordion mt-2">
    <div class="card">
        <div class="card-header" id="headingTwo1">
            <section class="mb-0 mt-0">
                <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#defaultAccordionTwo"
                    aria-expanded="false" aria-controls="defaultAccordionTwo">
                    <h3>Historial</h3> <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg></div>
                </div>
            </section>
        </div>
        <div id="defaultAccordionTwo" class="collapse" aria-labelledby="headingTwo1" data-bs-parent="#toggleAccordion"
            style="">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12 ">
                        <div class="mt-container mx-auto">
                            <div class="timeline-line">
                                <?php
                                /**
                                 * @var Historial $h
                                 */
                                foreach ($historial as $h) {
                                    ?>
                                    <div class="item-timeline">
                                        <p class="t-time"><?= $h->getFechaVisible() ?></p>
                                        <div class="t-dot t-dot-warning">
                                        </div>
                                        <div class="t-text">
                                            <p><?= $h->comentario ?></p>
                                            <p class="t-meta-time"><?= $h->getHoraVisible() ?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>