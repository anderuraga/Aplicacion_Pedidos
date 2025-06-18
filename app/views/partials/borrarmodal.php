<div class="modal fade inputForm-modal" id="borrarModal" tabindex="-1" role="dialog"
    aria-labelledby="borrarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" id="borrarModalLabel">
                <h5 class="modal-title">Borrar <?= $nombreBorrar ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form id="borrarForm" class="mt-0" method="post">
                    <input type="hidden" name="id" value="<?= $idborrar ?>">
                    <input type="hidden" name="action" value="borrar">
                    <h5>Una vez borrado los datos no se podrán recuperar</h5>
                    <h5>Para confirmar la acción, escribe "Borrar" en el campo siguiente: </h5>
                    <input type="text" name="confirmacion" class="form-control">
                </form>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-light-primary mt-2 mb-2 btn-no-effect"
                    data-bs-dismiss="modal">Cancelar</button>
                <button id="submitButton" type="submit" form="borrarForm"
                    class="btn btn-danger mt-2 mb-2 btn-no-effect">Borrar</button>
            </div>
        </div>
    </div>
</div>