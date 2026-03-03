<?php require_once HOMEDIR . '/../app/helpers/url.php'; ?>
<?php $titulo = "Pedidos Pendientes de Entregar" ?>


<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <h1 class="mt-2 ms-2"><?php echo $titulo?></h1>
            
            <?php var_dump($pedidos) ?>

                <div class="tab-content" id="pills-tabContent">

                                <tableclass="tabla table table-striped dt-table-hover pedidos-table" style="width:100%">
                                    <thead>
                                        <tr>                                           
                                            <th>Fecha</th>
                                            <th>Importe(con IVA)</th>
                                            <th>Departamento</th>
                                            <th>Area Gastos</th>
                                            <th>Subconcepto</th>
                                            <th>Proveedor</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        /** @var Pedido $p */
                                        foreach ($pedidos as $p) { ?>
                                            <tr>
                                                
                                                                                              
                                                <td><?= $p->departamento->nombre ?></td>
                                                <td><?= $p->areaGastos->nombre ?></td>
                                                <td><?= $p->subconcepto->nombre ?></td>
                                                <td><?= $p->proveedor->nombre ?></td>
                                                
                                                
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
 
            </div>
        </div>
    </div>
</div>
<?php require HOMEDIR . '/../app/views/partials/footer.php' ?>