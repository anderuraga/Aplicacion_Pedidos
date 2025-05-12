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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**
             * @var PedidosDAO
             */
            $pedidosDAO = $this->dao("Pedidos");
            $_SESSION['alert'] = $this->crear($pedidosDAO);
            if ($pedidosDAO->last_insert != null) {
                session_write_close();
                header("Location: vereditar?id=" . $pedidosDAO->last_insert);
            }
        }

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

    public function vereditar()
    {
        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");
        $pedido = $pedidosDAO->obtener($_GET['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['action'] == "siguiente") {
                switch ($pedido->estado->id) {
                    case 1:
                        $this->guardarPresupuestos($pedidosDAO);
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }



        $this->view("pedidos/formulario", ['pedido' => $pedido]);
    }

    private function crear(PedidosDAO $pedidosDAO)
    {
        global $usuario;
        $id_usuario = $usuario->id;
        $id_departamento = (int) ($_POST['departamento']);
        $id_subconcepto = (int) ($_POST['subconcepto']);
        $id_area_gasto = (int) ($_POST['areaGasto']);
        $id_proveedor = trim($_POST['proveedor']);
        $descripcion = trim($_POST['descripcion']);
        $importe = (float) getCantidadMysql($_POST['cantidad']);
        $anio_contable = date('Y');

        // Validación de campos obligatorios
        if (
            $id_usuario <= 0 || $id_departamento <= 0 || $id_subconcepto <= 0 ||
            $id_area_gasto <= 0 || $id_proveedor === '' || $descripcion === '' ||
            $importe <= 0 || $anio_contable <= 0
        ) {
            return [
                'tipo' => 'warning',
                'mensaje' => 'Todos los campos obligatorios deben rellenarse correctamente.'
            ];
        }

        $data = [
            'id_usuario' => $id_usuario,
            'id_departamento' => $id_departamento,
            'id_subconcepto' => $id_subconcepto,
            'id_area_gasto' => $id_area_gasto,
            'id_proveedor' => $id_proveedor,
            'descripcion' => $descripcion,
            'importe' => $importe,
            'anio_contable' => $anio_contable
        ];

        $ok = $pedidosDAO->crear($data);

        if ($ok) {
            return [
                'tipo' => 'success',
                'mensaje' => 'Pedido creado correctamente.'
            ];
        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Error al crear el pedido.'
            ];
        }
    }

    public function guardarPresupuestos(PedidosDAO $pedidosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;

        if (!$pedidoId) {
            $_SESSION['alert'] = 'ID de pedido no recibido.';
            header('Location: /Pedidos');
            return;
        }

        $archivos = [
            'presupuesto1',
            'presupuesto2',
            'presupuesto3',
        ];

        $rutaBase = __DIR__ . "/../../public/uploads/presupuestos/$pedidoId";
        if (!is_dir($rutaBase)) {
            mkdir($rutaBase, 0777, true);
        }

        $errores = [];

        foreach ($archivos as $campo) {
            if (!empty($_FILES[$campo]['tmp_name'])) {
                $original = $_FILES[$campo]['name'];
                $nombreLimpio = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $original);
                $rutaFinal = "$rutaBase/$nombreLimpio";

                if (move_uploaded_file($_FILES[$campo]['tmp_name'], $rutaFinal)) {
                    $ok = $pedidosDAO->insertar_presupuestos([
                        'id_pedido' => $pedidoId,
                        'documento' => $nombreLimpio,
                        'seleccionado' => $campo == "presupuesto1" ? 1 : 0
                    ]);
                    if(!$ok){
                        return [
                            'tipo' => 'danger',
                            'mensaje' => 'Error al subir archivo'
                        ];
                    }
                } else {
                    return [
                        'tipo' => 'danger',
                        'mensaje' => 'Error al subir archivos'
                    ];
                }
            }
        }

        $pedidosDAO->cambiarEstado($pedidoId,2);
        return [
            'tipo' => 'success',
            'mensaje' => 'Archivos subidos correctamente.'
        ];
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }


}