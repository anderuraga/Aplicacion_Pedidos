<div id="plantillasDocumentos" class="accordion mt-2">
    <div class="card">
        <div class="card-header" id="plantillasDocumentos">
            <section class="mb-0 mt-0">
                <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#plantillasDocumentos2" aria-expanded="false" aria-controls="plantillasDocumentos2">
                    <h3>Documentos Guardados</h3>
                    <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg></div>
                </div>
            </section>
        </div>
        <div id="plantillasDocumentos2" class="collapse" aria-labelledby="plantillasDocumentos2" data-bs-parent="#plantillasDocumentos" style="">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12 ">
                        <div class="mt-container mx-auto">
                                

                                <form id="borrarOtrosDocs" method="post">
                                    <input type="hidden" name="action" value="borrar_otros_doc">
                                    <input type="hidden" name="id" value="<?= $proveedor->id ?>">
                                    <ul>
                                        <?php foreach ($otrosdocs as $doc): ?>
                                            <li>
                                                <input type="checkbox" class="form-check-input" name="docs[]" value="<?= $doc['id'] ?>">
                                                <a target="_blank" href="<?= BASE_URL ?>public/uploads/otros_proveedor/<?= $proveedor->id ?>/<?= $doc['documento'] ?>"><?= $doc['tipo'] ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </form>

                                <button type="submit" form="borrarOtrosDocs" class="mt-2 mb-2 btn btn-danger">Borrar Seleccionados</button>
                                
                            <form method="post" id="borar_factura_form">
                                <input type="hidden" name="action" value="borrar_otros_doc">
                                <input type="hidden" name="id" value="<?= $proveedor->id ?>">
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

     


         
