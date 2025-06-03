<?php 
require_once __DIR__.'/../helpers/auth.php';

class MenuController extends Controller {
    
    public function index() {
        global $usuario;
        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");

        $data = [];
        if($usuario->tipo == ADMIN){
            $data["pedidosRevisar"] = $pedidosDAO->listar_estado(PEN_VALI);
            $data["pedidosArchivar"] = $pedidosDAO->listar_estado(PEN_ARCH);
        }


        $this->view("menu/index",$data);
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }
}