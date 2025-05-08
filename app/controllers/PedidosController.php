<?php
require_once __DIR__ . '/../helpers/auth.php';

class PedidosController extends Controller
{
    public function index()
    {

        $estadosDAO = $this->dao("Estados");
        $estados = $estadosDAO->listar();

        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");
        $pedidos = [];
        foreach ($estados as $e) {
            $pedidos[$e->id] = $pedidosDAO->listar_estado($e->id);
        }

        $this->view("pedidos/index", ['estados' => $estados, 'pedidos' => $pedidos]);
    }

    public function proveedor()
    {

        /**
         * @var AreasGastosDAO
         */
        $areasGastosDAO = $this->dao("AreasGastos");
        $areasGastos = $areasGastosDAO->listar();

        /**
         * @var TiposServicioDAO
         */
        $tiposServicioDAO = $this->dao("TiposServicio");
        $tiposServicio = $tiposServicioDAO->listar();

        /**
         * @var ProveedoresDAO
         */
        $proveedoresDAO = $this->dao("Proveedores");
        $proveedores = $proveedoresDAO->listar();

        /**
         * @var Usuario
         */
        $usuario = unserialize($_SESSION['usuario']);

        $data = [
            'areasGastos' => $areasGastos,
            'tiposServicio' => $tiposServicio,
            'proveedores' => $proveedores,
            'usuario' => $usuario,
        ];

        if($usuario->tipo==1){
            /**
             * @var DepartamentosDAO
             */
            $departamentosDAO = $this->dao("Departamentos");
            $departamentos = $departamentosDAO->listar();
            $data['departamentos'] = $departamentos;
        }

        $this->view("pedidos/proveedor", $data);
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }
}