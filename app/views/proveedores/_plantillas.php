<div id="plantillasAccordion" class="accordion mt-2">
    <div class="card">
        <div class="card-header" id="plantillasHeadingUno">
            <section class="mb-0 mt-0">
                <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#plantillasAccordionUno"
                    aria-expanded="false" aria-controls="plantillasAccordionUno">
                    <h3>Descargar Plantillas</h3>
                    <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg></div>
                </div>
            </section>
        </div>
        <div id="plantillasAccordionUno" class="collapse" aria-labelledby="plantillasHeadingUno"
            data-bs-parent="#plantillasAccordion" style="">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12 ">
                        <div class="mt-container mx-auto">

                                <ul class="lista_archivos">                                    
                                   <li>
                                        <a href="<?= BASE_URL ?>public/ALTA_TERCEROS.pdf" download="">
                                            <i class="bi bi-filetype-pdf text-danger" style="font-size: 25px;"></i>
                                            Alta Terceros
                                        </a>
                                    </li> 
                                                           
                                    <li>
                                        <a href="<?= BASE_URL ?>public/EF-10-Compromiso-mediobiental.doc" download="">
                                            <i class="bi bi-file-earmark-word fs-3 text-primary"></i>
                                            EF-10-Compromiso mediobiental
                                        </a>
                                    </li>
                              </ul> 
                           </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

     
  