<?php
require_once __DIR__ . '/../helpers/auth.php';

class MenuController extends Controller
{

    public function index()
    {
        global $usuario;
        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");

        $data = [];
        if ($usuario->tipo == ADMIN) {
            $data["pedidosRevisar"] = $pedidosDAO->listar_estado(PEN_VALI);
            $data["pedidosArchivar"] = $pedidosDAO->listar_estado(PEN_ARCH);
            $pedidosincidencias = $pedidosDAO->pedidos_incidencias_abiertas();
            $data["pedidosIncidencias"] = [];
            foreach ($pedidosincidencias as $pedIncid) {
                $data["pedidosIncidencias"][] = [$pedidosDAO->obtener($pedIncid['id_pedido']),$pedIncid['num_incidencias_abiertas']];
            }
        } else {
            $pedidosincidencias = $pedidosDAO->pedidos_incidencias_abiertas_JD($usuario->id);
            $data["pedidosIncidencias"] = [];
            foreach ($pedidosincidencias as $pedIncid) {
                $data["pedidosIncidencias"][] = [$pedidosDAO->obtener($pedIncid['id_pedido']),$pedIncid['num_incidencias_abiertas']];
            }

            /* TODO salen la de todos los usuarios, hay que filtrar por $usuario->id
            
            $data["pedidosProveedor"] = $pedidosDAO->listar_estado(PEN_PROV);
            $data["pedidosFactura"] = $pedidosDAO->listar_estado(PEN_FACT);

            */
        }


        $this->view("menu/index", $data);
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }
}