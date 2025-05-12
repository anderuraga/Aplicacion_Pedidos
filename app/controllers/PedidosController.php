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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['areagasto']) && $_POST['areagasto'] != 0 && isset($_POST['proveedor']) && isset($_POST['departamento']) && $_POST['departamento'] != 0) {
                session_write_close();
                header("Location:detalles?proveedor=$_POST[proveedor]&areaGasto=$_POST[areagasto]&departamento=$_POST[departamento]");
                exit;
            } else {
                $_SESSION['alert'] = [
                    'tipo' => 'warning',
                    'mensaje' => 'Es obligatorio seleccionar un proveedor y un area de gasto.'
                ];
            }
        }

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

        if ($usuario->tipo == 1) {
            /**
             * @var DepartamentosDAO
             */
            $departamentosDAO = $this->dao("Departamentos");
            $departamentos = $departamentosDAO->listar();
            $data['departamentos'] = $departamentos;
        }

        $this->view("pedidos/proveedor", $data);
    }

    public function detalles()
    {
        /**
         * @var ProveedoresDAO
         */
        $proveedoresDAO = $this->dao("Proveedores");
        $proveedor = $proveedoresDAO->obtener($_GET['proveedor']);

        /**
         * @var AreasGastosDAO
         */
        $areasGastosDAO = $this->dao("AreasGastos");
        $areaGastos = $areasGastosDAO->obtener($_GET['areaGasto']);


        /**
         * @var SubconceptosDAO
         */
        $areasGastosDAO = $this->dao("Subconceptos");
        $subconceptos = $areasGastosDAO->listar();

        /**
         * @var DepartamentosDAO
         */
        $departamentosDAO = $this->dao("Departamentos");
        $departamento = $departamentosDAO->obtener($_GET['departamento']);

        $data = [
            'proveedor' => $proveedor,
            'areaGastos' => $areaGastos,
            'subconceptos' => $subconceptos,
            'departamento' => $departamento
        ];

        $this->view("pedidos/detalles", $data);
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }
}