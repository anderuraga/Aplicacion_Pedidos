<?php
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/Mailer.php';
require_once __DIR__ . '/../../core/ErrorHandler.php';
//require_once __DIR__ . '/../models/vo/Estado.php';

use Mpdf\Mpdf;



class PedidosPendientesController extends Controller
{
    public function index()
    {    
        global $usuario;
    
        $pedidos = [];
        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");

        $pedidos = $pedidosDAO->listar_estado(Estado::$ESTADO_PENDIENTE);

        $this->view("pedidos/pendientes", ['pedidos' => $pedidos]);
    }


    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }


}