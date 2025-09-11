<?php
/**
 * @var Pedido $pedido
 */
?>


<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            width: 100%;
            max-width: 568px;
        }

        table {
            width: 100%;
            max-width: 568px;
            border-collapse: collapse;
            margin-bottom: 1em;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 2px 4px;
        }

        th{
            background-color: #c5d9f0;
        }

        .header-table td {
            border: none;
            padding: 0;            
        }

        .section {
            background: #eee;
            font-weight: bold;
        }      

        img {
            display: block;
            margin: auto;
        }
        .center {
            text-align: center;
        }
        p {
           margin: 4px; 
        }
    </style>
</head>


<body>
    <div>
        <img src="data:image/png;base64,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" alt="" />
        <table cellspacing="0" cellpadding="0">
            <thead>
                    <tr>
                        <th colspan="2">
                            <p>RESOLUCIÓN DE AUTORIZACIÓN DE GASTO Y ADJUDICACIÓN DE CONTRATO MENOR</p> 
                        </th>
                    </tr>
            </thead>
            <tbody>
                <tr>
                    <td><p><b>Centro Docente: CIFP ELORRIETA – ERREKA MARI LHII</b></p></td>
                </tr>
                <tr>
                    <td>
                        <p><b>N&ordm;</em> <em> de expediente:</b>  <?= $pedido->referencia ?> </p>
                    </td>                   
                </tr>             
        
                <tr>
                    <td>
                        <p><b>Descripción:</b></p>
                        <p> <?= $pedido->descripcion ?> </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>Tipo de contrato: </b>
                         <select name="tipo_contrato">
                            <option value="Servicio">Servicio</option>
                            <option value="Suminitros ">Suminitros</option>
                            <option value="Obras">Obras</option>
                        </select>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>Adjudicatario:</b> <?= $pedido->proveedor->nombre ?>  </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>DNI/CIF del adjudicatario: </b> <?= $pedido->proveedor->cif ?>  </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>Importe sin IVA: </b> <input size="15" type="text" placeholder="dinero con IVA "> &euro; </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>Importe del IVA: </b> <input size="15" type="text" placeholder="dinero con IVA "> &euro; </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>Importe con IVA: </b> <?= $pedido->cantidad_formato_iva() ?> &euro;</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>Plazo de ejecución:</b> <input type="text" size="55" placeholder="por ejemplo 7 meses"></p>                        
                    </td>                    
                </tr>
                <tr>
                    <td>
                        <textarea cols="72" rows="10" placeholder="Escribir si corresponde alguna aclaración sobre el plazo de ejecución"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="center"><b>RESUELVO</b></p>                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>PRIMERO.- Autorizar dicho gasto por un importe total, I.V.A. incluido de <input size="15" type="text" placeholder="dinero con IVA "> &euro; </p>                        
                    </td>
                </tr>
                 <tr>
                    <td>
                        <p>SEGUNDO.- Contratar con la referida empresa los trabajos que constituyen el objeto de la contratación que figura en el encabezamiento. </p>                        
                    </td>
                </tr>
                 <tr>
                    <td>
                        <p>TERCERO.- La Orden de Pago se tramitará tras la adecuada realización del objeto de la contratación, y previa presentación de la factura con el Vº Bº del Director o Directora.</p>                        
                    </td>
                </tr>


                <tr>
                    <td>
                        <p><input type="text" name="fecha" placeholder="Escribe la fecha, En bilbao a dia x de mes y" size="50"></p>
                        <p>(Firma&nbsp;y&nbsp;sello)</p>
                    </td>
                </tr>
        
    </div>

 

    </body>
   