  <div class="statbox widget box box-shadow mt-2">
        <div class="widget-content widget-content-area p-2">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 ">
                    <h2>Opciones</h2>
                    <?php switch ($pedido->estado->id) {
                        case BORRADOR: ?>
                            <form id="subirFactura" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                <button class="btn btn-success float-end">Enviar para validar por Administración</button><br>
                            </form>
                            <?php break;
                        case PEN_VALI: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <form class="mb-2" id="seguir" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>">
                                    <input type="hidden" name="action" value="siguiente">
                                    <button class="btn btn-success float-end">Enviar Proveedor</button><br>
                                </form>
                            <?php } ?>
                            <?php break;
                        case PEN_PROV: ?>
                            <form class="mb-2" id="subirFacturas" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="action" value="siguiente">
                                <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                <button class="btn btn-success float-end">Cambiar a P.Factura</button><br>
                            </form>
                            <?php break;
                        case PEN_FACT: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <form class="mb-2 formulario" id="subirFacturas" method="post"
                                    action="Pedidos/vereditar?id=<?= $pedido->id ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="siguiente">
                                    <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                    <button class="btn btn-success float-end">Cambiar a P.Archivado</button><br>
                                </form>
                            <?php } ?>
                            <?php break;
                        case PEN_ARCH: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <form class="mb-2" id="seguir" method="post" action="Pedidos/vereditar?id=<?= $pedido->id ?>">
                                    <input type="hidden" name="action" value="siguiente">
                                    <input type="hidden" name="id" value="<?= $pedido->id ?>">
                                    <a target="_blank" href="<?= BASE_URL ?>Pedidos/pdf/<?= $pedido->id ?>"
                                        class="btn btn-primary">Imprimir</a>
                                    <button class="btn btn-success float-end">Archivar</button><br>
                                </form>
                            <?php } ?>
                            <?php break;
                        case ARCHIVADO: ?>
                            <?php if ($usuario->tipo == ADMIN) { ?>
                                <a target="_blank" href="<?= BASE_URL ?>Pedidos/pdf/<?= $pedido->id ?>"
                                    class="btn btn-primary">Imprimir Hoja de Pedidos</a>
                                <a target="_blank" href="<?= BASE_URL ?>Pedidos/anexo6/<?= $pedido->id ?>"
                                    class="btn btn-primary">Imprimir Anexo VI</a>
                            <?php } ?>
                            <?php break;
                        default:
                            break;
                    } ?>

                    <a class="btn btn-warning"
                        href="<?= BASE_URL ?>Incidencias/vereditar?id=0&pedido=<?= $pedido->id ?>">Nueva Incidencia</a>

                    <?php if ($usuario->tipo == ADMIN): ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#borrarModal">Eliminar</button>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>