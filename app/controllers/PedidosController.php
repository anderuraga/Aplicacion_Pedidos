<?php
require_once __DIR__ . '/../helpers/auth.php';

class PedidosController extends Controller
{
    public function index()
    {
        global $usuario;
        $estadosDAO = $this->dao("Estados");
        $estados = $estadosDAO->listar();

        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['pedidos'])) {
                $_SESSION['alert'] = [
                    'tipo' => 'success',
                    'mensaje' => 'Se han archivado los pedidos correctamente.'
                ];
                /**
                 * @var TransaccionesDAO
                 */
                $transaccionesDAO = $this->dao("Transacciones");
                foreach ($_POST['pedidos'] as $pedido) {
                    $return = $this->archivar($pedidosDAO, $transaccionesDAO, $pedido);
                    if ($return['tipo'] != "success") {
                        $_SESSION['alert'] = [
                            'tipo' => 'warning',
                            'mensaje' => 'Ha sucedido un error al archivar alguno de los pedidos.'
                        ];
                    }
                }
            }
        }

        $pedidos = [];
        foreach ($estados as $e) {
            if ($usuario->tipo == ADMIN) {
                $pedidos[$e->id] = $pedidosDAO->listar_estado($e->id);
            } else {
                $pedidos[$e->id] = $pedidosDAO->listar_estado_departamento($e->id, $usuario->departamento->id);
            }

        }

        $this->view("pedidos/index", ['estados' => $estados, 'pedidos' => $pedidos]);
    }

    public function proveedor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['proveedor'])) {
                session_write_close();
                header("Location:areagastos?proveedor=$_POST[proveedor]");
                exit;
            } else {
                $_SESSION['alert'] = [
                    'tipo' => 'warning',
                    'mensaje' => 'Es obligatorio seleccionar un proveedor.'
                ];
            }
        }

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
            'tiposServicio' => $tiposServicio,
            'proveedores' => $proveedores,
            'usuario' => $usuario,
        ];

        $this->view("pedidos/proveedor", $data);
    }

    public function areagastos()
    {
        if (!isset($_GET['proveedor'])) {
            $_SESSION['alert'] = [
                'tipo' => 'danger',
                'mensaje' => 'No hay proveedor seleccionado.'
            ];
            session_write_close();
            header("Location:proveedor");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['areagasto']) && $_POST['areagasto'] != 0 && isset($_POST['proveedor']) && isset($_POST['departamento']) && $_POST['departamento'] != 0) {
                session_write_close();
                header("Location:detalles?proveedor=$_POST[proveedor]&areaGasto=$_POST[areagasto]&departamento=$_POST[departamento]");
                exit;
            } else {
                $_SESSION['alert'] = [
                    'tipo' => 'warning',
                    'mensaje' => 'Es obligatorio seleccionar un area de gasto.'
                ];
            }
        }

        /**
         * @var AreasGastosDAO
         */
        $areasGastosDAO = $this->dao("AreasGastos");
        $areasGastos = $areasGastosDAO->listar();


        $data = [
            'areasGastos' => $areasGastos,
        ];

        global $usuario;
        if ($usuario->tipo == ADMIN) {
            /**
             * @var DepartamentosDAO
             */
            $departamentosDAO = $this->dao("Departamentos");
            $departamentos = $departamentosDAO->listar();
            $data['departamentos'] = $departamentos;
        }
        $this->view("pedidos/areagastos", $data);
    }

    public function detalles()
    {
        /**
         * @var AreasGastosDAO
         */
        $areasGastosDAO = $this->dao("AreasGastos");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**
             * @var PedidosDAO
             */
            $pedidosDAO = $this->dao("Pedidos");
            $_SESSION['alert'] = $this->crear($pedidosDAO, $areasGastosDAO);
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
        global $usuario;
        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");
        $pedido = $pedidosDAO->obtener($_GET['id']);

        /**
         * @var IncidenciasDAO
         */
        $incidenciasDAO = $this->dao("Incidencias");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['action'] == "siguiente") {
                switch ($pedido->estado->id) {
                    case BORRADOR:
                        $_SESSION['alert'] = $this->guardarPresupuestos($pedidosDAO, $pedido);
                        $pedido = $pedidosDAO->obtener($_GET['id']);
                        break;
                    case PEN_VALI:
                        $pedidosDAO->cambiarEstado($pedido->id, 3);
                        $pedidosDAO->rellenarEstado(3, $pedido->id, "Se ha enviado el pedido al proveedor");
                        $pedido = $pedidosDAO->obtener($_GET['id']);
                        break;
                    case PEN_PROV:
                        $_SESSION['alert'] = $this->guardarAlbaran($pedidosDAO);
                        $pedido = $pedidosDAO->obtener($_GET['id']);
                        break;
                    case PEN_FACT:
                        $_SESSION['alert'] = $this->guardarFactura($pedidosDAO);
                        $pedido = $pedidosDAO->obtener($_GET['id']);
                        break;
                    case PEN_ARCH:
                        $transaccionesDAO = $this->dao("Transacciones");
                        $this->archivar($pedidosDAO, $transaccionesDAO);
                        $pedidosDAO->rellenarEstado(6, $pedido->id, "Se ha confirmado el pago");
                        $pedido = $pedidosDAO->obtener($_GET['id']);
                        break;
                    default:
                        break;
                }
            } else if ($_POST['action'] == "incidencia") {
                if ($incidenciasDAO->marcar_solucionada($_POST['id'])) {
                    $pedidosDAO->rellenarEstado($pedido->estado->id, $pedido->id, "Incidencia marcada como solucionada");
                    $_SESSION['alert'] = [
                        'tipo' => 'success',
                        'mensaje' => 'Incidencia marcada como resuelta correctamente.'
                    ];
                } else {
                    $_SESSION['alert'] = [
                        'tipo' => 'warning',
                        'mensaje' => 'Error al marcar como resuelta la incidencia.'
                    ];
                }
            } else if ($_POST['action'] == "editar") {
                /**
                 * @var AreasGastosDAO
                 */
                $areasGastosDAO = $this->dao("AreasGastos");

                $_SESSION['alert'] = $this->editar($pedidosDAO, $areasGastosDAO);
                $pedido = $pedidosDAO->obtener($_POST['id']);
            }
        }

        $historial = $pedidosDAO->obtener_historial($pedido->id);


        $incidenciasActivas = $incidenciasDAO->listar_estado($pedido->id, 0);
        $incidenciasResueltas = $incidenciasDAO->listar_estado($pedido->id, 1);

        /**
         * @var SubconceptosDAO
         */
        $subconceptosDAO = $this->dao("Subconceptos");
        $subconceptos = $subconceptosDAO->listar();

        /**
         * @var TiposServicioDAO
         */
        $tiposServiciosDAO = $this->dao("TiposServicio");
        $tiposServicios = $tiposServiciosDAO->listar();

        /**
         * @var ProveedoresDAO
         */
        $proveedoresDAO = $this->dao("Proveedores");
        $proveedores = $proveedoresDAO->listar();

        $data = [
            'pedido' => $pedido,
            'historial' => $historial,
            'incidenciasActivas' => $incidenciasActivas,
            'incidenciasResueltas' => $incidenciasResueltas,
            'subconceptos' => $subconceptos,
            'tiposServicios' => $tiposServicios,
            'proveedores' => $proveedores
        ];

        if ($usuario->tipo == ADMIN) {
            /**
             * @var AreasGastosDAO
             */
            $areasGastosDAO = $this->dao("AreasGastos");
            $areasGastos = $areasGastosDAO->listar();
            $data['areasGastos'] = $areasGastos;
        }


        if ($pedido->estado->id > 0) {
            $presupuestos = $pedidosDAO->obtener_presupuestos($pedido->id);
            $data['presupuestos'] = $presupuestos;
        }

        $this->view("pedidos/formulario", $data);
    }

    private function crear(PedidosDAO $pedidosDAO, AreasGastosDAO $areasGastosDAO)
    {
        global $usuario;
        $id_usuario = $usuario->id;
        $id_departamento = (int) ($_POST['departamento'] ?? 0);
        $id_subconcepto = (int) ($_POST['subconcepto'] ?? 0);
        $id_area_gasto = (int) ($_POST['areaGasto'] ?? 0);
        $id_proveedor = trim($_POST['proveedor'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $importe = (float) getCantidadMysql($_POST['cantidad'] ?? 0);
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

        $areaGastos = $areasGastosDAO->obtener($id_area_gasto);
        $total = floatval($areaGastos->diferencia);
        if ($importe > $total) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'No es posible hacer un pedido con un importe por encima del saldo del area de gasto.'
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
            $pedidosDAO->rellenarEstado(1, $pedidosDAO->last_insert, "Se ha creado el pedido");
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

    private function editar(PedidosDAO $pedidosDAO, AreasGastosDAO $areasGastosDAO)
    {
        global $usuario;
        $id =(int) $_POST['id'];
        $importe = (float) getCantidadMysql($_POST['cantidad'] ?? 0);

        $pedido = $pedidosDAO->obtener($id);

        $areaGastos = $areasGastosDAO->obtener($pedido->areaGastos->id);
        $total = floatval($areaGastos->diferencia);

        if ($importe != $pedido->importe) {
            if ($importe > $total) {
                return [
                    'tipo' => 'danger',
                    'mensaje' => 'No es posible cambiar el importe ya que superaria el saldo del area de gasto.'
                ];
            } else {
                if (!$pedidosDAO->cambiarImporte($id, getCantidadMysql($_POST['cantidad'] ?? 0))) {
                    return [
                        'tipo' => 'danger',
                        'mensaje' => 'Error al cambiar el importe.'
                    ];
                }
            }
        }

        if ($usuario->tipo == ADMIN) {

            $areaGasto = $_POST['areagasto'];

            if ($pedido->areaGastos->id != $areaGasto) {
                $newareaGastos = $areasGastosDAO->obtener($areaGasto);
                $total = floatval($newareaGastos->diferencia);
                if ($importe > $total) {
                    return [
                        'tipo' => 'danger',
                        'mensaje' => 'No es posible cambiar el pedido al area de gasto ya que el importe supera el saldo del area de gasto.'
                    ];
                } else {
                    if (!$pedidosDAO->cambiarAreaGasto($id, $areaGasto, $pedido->referencia)) {
                        return [
                            'tipo' => 'danger',
                            'mensaje' => 'Error al cambiar el area de gasto.'
                        ];
                    }
                }
            }
        }

        return [
            'tipo' => 'success',
            'mensaje' => 'Editado correctamente.'
        ];
    }

    public function guardarPresupuestos(PedidosDAO $pedidosDAO, Pedido $pedido)
    {
        $pedidoId = $_POST['id'] ?? null;

        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido'
            ];
        }

        if ($pedido->comprobacion_presupuestos()) {
            if (empty($_FILES["presupuesto1"]['tmp_name']) || empty($_FILES["presupuesto2"]['tmp_name']) || empty($_FILES["presupuesto3"]['tmp_name']) || empty($_FILES["anexo"]['tmp_name'])) {
                return [
                    'tipo' => 'danger',
                    'mensaje' => 'Hay que subir todos los archivos'
                ];
            }
        } else {
            if (empty($_FILES["presupuesto1"]['tmp_name'])) {
                return [
                    'tipo' => 'danger',
                    'mensaje' => 'Hay que subir todos los archivos'
                ];
            }
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
                    if (!$ok) {
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
        if ($pedido->comprobacion_presupuestos()) {
            $original = $_FILES["anexo"]['name'];
            $nombreLimpio = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $original);
            $rutaFinal = "$rutaBase/$nombreLimpio";

            if (move_uploaded_file($_FILES["anexo"]['tmp_name'], $rutaFinal)) {
                $ok = $pedidosDAO->insertar_anexo($pedidoId, $nombreLimpio);
                if (!$ok) {
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

        $pedidosDAO->cambiarEstado($pedidoId, 2);
        $pedidosDAO->rellenarEstado(2, $pedidoId, "Se han subido los presupuestos");
        return [
            'tipo' => 'success',
            'mensaje' => 'Archivos subidos correctamente.'
        ];
    }

    public function guardarAlbaran(PedidosDAO $pedidosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;

        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido'
            ];
        }

        if (empty($_FILES["albaran"]['tmp_name'])) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Hay que subir todos los archivos'
            ];
        }

        $rutaBase = __DIR__ . "/../../public/uploads/presupuestos/$pedidoId";
        if (!is_dir($rutaBase)) {
            mkdir($rutaBase, 0777, true);
        }

        $original = $_FILES["albaran"]['name'];
        $nombreLimpio = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $original);
        $rutaFinal = "$rutaBase/$nombreLimpio";

        if (move_uploaded_file($_FILES["albaran"]['tmp_name'], $rutaFinal)) {
            $ok = $pedidosDAO->insertar_albaran($pedidoId, $nombreLimpio);
            if (!$ok) {
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

        $pedidosDAO->cambiarEstado($pedidoId, 4);
        $pedidosDAO->rellenarEstado(4, $pedidoId, "Se ha subido el albarán");
        return [
            'tipo' => 'success',
            'mensaje' => 'Archivo subido correctamente.'
        ];
    }

    public function guardarFactura(PedidosDAO $pedidosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;

        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido'
            ];
        }

        if (empty($_FILES["factura"]['tmp_name'])) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Hay que subir todos los archivos'
            ];
        }

        $rutaBase = __DIR__ . "/../../public/uploads/presupuestos/$pedidoId";
        if (!is_dir($rutaBase)) {
            mkdir($rutaBase, 0777, true);
        }

        $original = $_FILES["factura"]['name'];
        $nombreLimpio = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $original);
        $rutaFinal = "$rutaBase/$nombreLimpio";

        if (move_uploaded_file($_FILES["factura"]['tmp_name'], $rutaFinal)) {
            $ok = $pedidosDAO->insertar_factura($pedidoId, $nombreLimpio);
            if (!$ok) {
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

        $pedidosDAO->cambiarEstado($pedidoId, 5);
        $pedidosDAO->rellenarEstado(5, $pedidoId, "Se ha subido la factura");
        return [
            'tipo' => 'success',
            'mensaje' => 'Archivo subido correctamente.'
        ];
    }

    public function archivar(PedidosDAO $pedidosDAO, TransaccionesDAO $transaccionesDAO, int $pedido_id = null)
    {
        $pedidoId = $_POST['id'] ?? $pedido_id;

        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido'
            ];
        }
        if ($pedidosDAO->cambiarEstado($pedidoId, 6)) {
            $pedido = $pedidosDAO->obtener($pedidoId);
            $fecha = date("Y-m-d H:i:s");
            $descr = "Pedido " . $pedido->referencia . " archivado";
            $ok = $transaccionesDAO->crear($fecha, $descr, $pedido->areaGastos->id, getCantidadMysql("-" . $pedido->importe));
            if ($ok) {
                return [
                    'tipo' => 'success',
                    'mensaje' => 'Pedido archivado correctamente.'
                ];
            } else {
                return [
                    'tipo' => 'danger',
                    'mensaje' => 'Error al cambiar el estado del pedido'
                ];
            }
        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Error al cambiar el estado del pedido'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }
}
