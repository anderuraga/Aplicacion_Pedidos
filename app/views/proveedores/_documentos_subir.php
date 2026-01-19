<div id="subirDocAccordation" class="accordion mt-2">
    <div class="card">
        <div class="card-header" id="plantillasHeadingUno">
            <section class="mb-0 mt-0">
                <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#plantillasAccordion2"
                    aria-expanded="false" aria-controls="plantillasAccordion2">
                    <h3>Subir Nuevo Documento</h3>
                    <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg></div>
                </div>
            </section>
        </div>
        <div id="plantillasAccordion2" class="collapse" aria-labelledby="plantillasHeadingUno"  data-bs-parent="#plantillasAccordion" style="">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12 ">
                        <div class="mt-container mx-auto">
                              
                                 <form onsubmit="ajustarValorOtros()" class="mb-2 mt-2 formulario" id="subirOtroDoc" method="post" enctype="multipart/form-data">

                                    <input type="hidden" name="action" value="subir_otro_doc">
                                    <input type="hidden" name="id" value="<?= $proveedor->id ?>">
                                    
                                    <label for="referencia">Selecciona Tipo Documento: *</label>
                                    <select class="form-control mb-2" id="tipo" name="tipo" required>
                                        <option value="alta-terceros">Alta Terceros</option>
                                        <option value="compromiso-medioambiental">Compromiso Medioambiental</option>
                                        <option value="justificante-bancario">Justificante Bancario</option>
                                        <option value="otros">Otros</option>
                                    </select>   

                                    <label for="factura"><i>Archivo: *</i></label><br>
                                    <input type="file" id="archivo" name="archivo" accept="application/pdf" required>
                                </form>
                                
                                <button type="submit" form="subirOtroDoc" class="btn btn-success float-end">Subir documento</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   