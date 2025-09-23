<?php
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/Mailer.php';
require_once __DIR__ . '/../../core/ErrorHandler.php';

use Mpdf\Mpdf;



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
        $incidencias = [];
        foreach ($estados as $e) {
            if ($usuario->tipo == ADMIN) {
                $pedidos[$e->id] = $pedidosDAO->listar_estado($e->id);
            } else {
                $pedidos[$e->id] = $pedidosDAO->listar_estado_departamento($e->id, $usuario->departamento->id);
            }

            foreach ($pedidos[$e->id] as $p) {
                $incidencias[$p->id] = $pedidosDAO->pedido_incidencias_abiertas($p->id);
            }
        }

        $this->view("pedidos/index", ['estados' => $estados, 'pedidos' => $pedidos, 'incidencias' => $incidencias]);
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
        $proveedores = $proveedoresDAO->listar(true);

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
            if (isset($_POST['areagasto']) && $_POST['areagasto'] != 0 && isset($_POST['proveedor'])) {
                session_write_close();
                header("Location:detalles?proveedor=$_POST[proveedor]&areaGasto=$_POST[areagasto]");
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
        /**
         * @var ProveedoresDAO
         */
        $proveedoresDAO = $this->dao("Proveedores");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**
             * @var PedidosDAO
             */
            $pedidosDAO = $this->dao("Pedidos");
            $_SESSION['alert'] = $this->crear($pedidosDAO, $areasGastosDAO, $proveedoresDAO);
            if ($pedidosDAO->last_insert != null) {
                session_write_close();
                header("Location: vereditar?id=" . $pedidosDAO->last_insert);
                exit;
            }
        }


        $proveedor = $proveedoresDAO->obtener($_GET['proveedor']);


        $areaGastos = $areasGastosDAO->obtener($_GET['areaGasto']);


        /**
         * @var SubconceptosDAO
         */
        $areasGastosDAO = $this->dao("Subconceptos");
        $subconceptos = $areasGastosDAO->listar();

        $data = [
            'proveedor' => $proveedor,
            'areaGastos' => $areaGastos,
            'subconceptos' => $subconceptos,
            'departamento' => $areaGastos->departamento
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

        /**
         * @var ProveedoresDAO
         */
        $proveedoresDAO = $this->dao("Proveedores");

        /**
         * @var UsuariosDAO
         */
        $usuariosDAO = $this->dao("Usuarios");


        /**
         * @var TransaccionesDAO
         */
        $transaccionesDAO = $this->dao("Transacciones");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['action'] == "siguiente") {
                switch ($pedido->estado->id) {
                    case BORRADOR:
                        $_SESSION['alert'] = $this->guardarPresupuestos($pedidosDAO, $pedido, $usuariosDAO);
                        $pedido = $pedidosDAO->obtener($_GET['id']);
                        break;
                    case PEN_VALI:
                        $_SESSION['alert'] = $this->pendienteProveedor($pedidosDAO, $pedido, $usuariosDAO);
                        $pedido = $pedidosDAO->obtener($_GET['id']);
                        break;
                    case PEN_PROV:
                        $_SESSION['alert'] = $this->guardarAlbaran($pedidosDAO, $usuariosDAO);
                        $pedido = $pedidosDAO->obtener($_GET['id']);
                        break;
                    case PEN_FACT:
                        $_SESSION['alert'] = $this->guardarFactura($pedidosDAO, $usuariosDAO);
                        $pedido = $pedidosDAO->obtener($_GET['id']);
                        break;
                    case PEN_ARCH:
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
                    $correos = $usuariosDAO->obtenerCorreosAdmin();
                    $mailer = new Mailer();
                    $mailer->enviarCorreo(
                        $correos,
                        "Incidencia Resuelta",
                        "IncidenciaResuelta",
                        [
                            'referencia' => $pedido->referencia
                        ]
                    );
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

                $_SESSION['alert'] = $this->editar($pedidosDAO, $areasGastosDAO, $proveedoresDAO, $transaccionesDAO);
                $pedido = $pedidosDAO->obtener($_POST['id']);
            } else if ($_POST['action'] == "documentos") {
                $_SESSION['alert'] = $this->guardarDocumentos($pedidosDAO);
                $pedido = $pedidosDAO->obtener($_POST['id']);
            } else if ($_POST['action'] == "subir_factura") {
                $_SESSION['alert'] = $this->subirFactura($pedidosDAO);
                $pedido = $pedidosDAO->obtener($_POST['id']);
            } else if ($_POST['action'] == "borrar") {
                $_SESSION['alert'] = $this->borrar($pedidosDAO, $transaccionesDAO);
                if ($_SESSION['alert']['tipo'] == "success") {
                    session_write_close();
                    header("Location: " . BASE_URL . "Pedidos");
                    exit;
                }
            } else if ($_POST['action'] == "borrar_factura") {
                $_SESSION['alert'] = $this->borrarFactura($pedidosDAO);
                $pedido = $pedidosDAO->obtener($_POST['id']);
            } else if ($_POST['action'] == "subir_otro_doc") {
                $_SESSION['alert'] = $this->subirOtroDoc($pedidosDAO);
                $pedido = $pedidosDAO->obtener($_POST['id']);
            } else if ($_POST['action'] == "borrar_otros_doc") {
                $_SESSION['alert'] = $this->borrarOtrosDoc($pedidosDAO);
                $pedido = $pedidosDAO->obtener($_POST['id']);
            }
        }

        $historial = $pedidosDAO->obtener_historial($pedido->id);
        $otrosdocs = $pedidosDAO->obtener_otros_docs($pedido->id);


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
         * @var DepartamentosDAO
         */
        $departamentosDAO = $this->dao("Departamentos");
        $departamentos = $departamentosDAO->listar();

        /**
         * @var EstadosDAO
         */
        $estadosDAO = $this->dao("Estados");
        $estados = $estadosDAO->listar();


        $proveedores = $proveedoresDAO->listar(true);


        $usuarios = $usuariosDAO->listar();

        $data = [
            'pedido' => $pedido,
            'historial' => $historial,
            'incidenciasActivas' => $incidenciasActivas,
            'incidenciasResueltas' => $incidenciasResueltas,
            'subconceptos' => $subconceptos,
            'tiposServicios' => $tiposServicios,
            'proveedores' => $proveedores,
            'departamentos' => $departamentos,
            'usuarios' => $usuarios,
            'otrosdocs' => $otrosdocs,
            'estados' => $estados
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

    private function crear(PedidosDAO $pedidosDAO, AreasGastosDAO $areasGastosDAO, ProveedoresDAO $proveedoresDAO)
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

        /**
         * @var AreaGastos
         */
        $areaGastos = $areasGastosDAO->obtener($id_area_gasto);
        $total = floatval($areaGastos->diferencia);
        if ($importe > $total) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'No es posible hacer un pedido con un importe por encima del saldo del area de gasto.'
            ];
        }

        $proveedor = $proveedoresDAO->obtener($id_proveedor);
        $totalProveedor = $proveedor->gasto_anual;
        if ($totalProveedor + $importe >= $proveedor->limite) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'El importe superaría el máximo permitido para el proveedor.'
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

    private function editar(PedidosDAO $pedidosDAO, AreasGastosDAO $areasGastosDAO, ProveedoresDAO $proveedoresDAO, TransaccionesDAO $transaccionesDAO)
    {
        global $usuario;
        $id = (int) $_POST['id'];
        $importe = (float) getCantidadMysql($_POST['cantidad'] ?? 0);
        $id_subconcepto = (int) ($_POST['subconcepto'] ?? 0);
        $descripcion = trim($_POST['descripcion'] ?? '');
        $id_proveedor = $_POST['proveedor'] ?? null;

        if (!$id || $importe == 0 || $descripcion === '' || !$id_proveedor) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Hay campos sin valor, revise el importa, la descripción y el proveedor.'
            ];
        }

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
                if (!$pedidosDAO->cambiarImporte($id, $importe)) {

                    return [
                        'tipo' => 'danger',
                        'mensaje' => 'Error al cambiar el importe.'
                    ];
                } else {
                    if ($pedido->transaccion->id != 0) {
                        /**
                         * @var Transaccion
                         */
                        $tra = $pedido->transaccion;
                        $transaccionesDAO->editar($tra->id, $tra->fecha, $tra->descripcion, $pedido->areaGastos->id, -$importe);
                    }
                }
            }
        }

        if ($id_proveedor != $pedido->proveedor->id) {
            $proveedor = $proveedoresDAO->obtener($id_proveedor);
            $totalProveedor = $proveedor->gasto_anual;
            if ($totalProveedor + $importe >= $proveedor->limite) {
                return [
                    'tipo' => 'danger',
                    'mensaje' => 'El importe superaría el máximo permitido para.'
                ];
            } else {
                if (!$pedidosDAO->cambiarProveedor($id, $id_proveedor)) {
                    return [
                        'tipo' => 'danger',
                        'mensaje' => 'Error al cambiar el proveedor.'
                    ];
                }
            }
        }

        if (!$pedidosDAO->editar($id, $id_subconcepto, $descripcion)) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Error al cambiar los datos.'
            ];
        }


        if ($usuario->tipo == ADMIN) {

            $estado_id = $_POST['estado'];
            $areaGasto = $_POST['areagasto'];

            $referencia = $_POST['referencia'];
            $fechaCreacion = $_POST['fechaCreacion'];
            $departamento = $_POST['departamento'];
            $usuario_id = $_POST['usuario_id'];

            $ok = $pedidosDAO->editar_admin(
                $id,
                $referencia,
                $fechaCreacion,
                $departamento,
                $usuario_id,
                $estado_id
            );

            if (!$ok) {
                return [
                    'tipo' => 'danger',
                    'mensaje' => 'Error al cambiar los datos.'
                ];
            }

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

        if ($pedido->transaccion->id != 0) {
            $tra = $pedido->transaccion;
            $tra_desc = str_replace($pedido->referencia, $referencia, $tra->descripcion);
            $transaccionesDAO->editar($tra->id, $tra->fecha, $tra_desc, $areaGasto, -$importe);
        }

        $pedidosDAO->rellenarEstado($pedido->estado->id, $pedido->id, "Se han editado los datos del pedido.");

        return [
            'tipo' => 'success',
            'mensaje' => 'Editado correctamente.'
        ];
    }

    public function guardarPresupuestos(PedidosDAO $pedidosDAO, Pedido $pedido, UsuariosDAO $usuariosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;

        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido'
            ];
        }
        $pedido = $pedidosDAO->obtener($pedidoId);
        if ($pedido->comprobacion_presupuestos()) {
            $presupuestos = $pedidosDAO->obtener_presupuestos($pedido->id);
            if (count($presupuestos) < 3) {
                return [
                    'tipo' => 'danger',
                    'mensaje' => 'Tiene que haber 3 presupuestos adjuntados a este pedido'
                ];
            }

            /* Ya no es necesario el Anexo III, se puede generar más adelante cuando tengamos la factura
            if (is_null($pedido->anexo)) {
                return [
                    'tipo' => 'danger',
                    'mensaje' => 'Es necesario adjuntar el anexo III correspondiente'
                ];
            }
            */
        }

        $pedidosDAO->cambiarEstado($pedidoId, 2);
        $pedidosDAO->rellenarEstado(2, $pedidoId, "Se han subido los presupuestos");

        $correos = $usuariosDAO->obtenerCorreosAdmin();
        $mailer = new Mailer();
        $mailer->enviarCorreo(
            $correos,
            "Nuevo pedido pendiente de revisión",
            "PendienteRevision",
            [
                'referencia' => $pedido->referencia
            ]
        );

        return [
            'tipo' => 'success',
            'mensaje' => 'Estado cambiado correctamente.'
        ];
    }

    public function guardarAlbaran(PedidosDAO $pedidosDAO, UsuariosDAO $usuariosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;

        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido'
            ];
        }


        $pedido = $pedidosDAO->obtener($pedidoId);
        if ($pedido->albaran == null) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Es necesario adjuntar un albarán'
            ];
        }

        $pedidosDAO->cambiarEstado($pedidoId, 4);
        $pedidosDAO->rellenarEstado(4, $pedidoId, "Se ha subido el albarán");

        $correos = $usuariosDAO->obtenerCorreosAdmin();
        $correoJD = $pedido->usuario->correo;
        $cc = [
            $correoJD
        ];
        $mailer = new Mailer();
        $mailer->enviarCorreo(
            $correos,
            "Pedido pendiente de factura",
            "PendienteFactura",
            [
                'referencia' => $pedido->referencia
            ],
            $cc
        );


        return [
            'tipo' => 'success',
            'mensaje' => 'Estado cambiado correctamente.'
        ];
    }

    public function guardarFactura(PedidosDAO $pedidosDAO, UsuariosDAO $usuariosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;

        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido'
            ];
        }

        $pedido = $pedidosDAO->obtener($pedidoId);
        if ($pedido->factura->id == 0) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Es necesario adjuntar una factura'
            ];
        }

        $pedidosDAO->cambiarEstado($pedidoId, 5);
        $pedidosDAO->rellenarEstado(5, $pedidoId, "Se ha subido la factura");

        $correos = $usuariosDAO->obtenerCorreosAdmin();
        $correoJD = $pedido->usuario->correo;
        $cc = [
            $correoJD
        ];
        $mailer = new Mailer();
        $mailer->enviarCorreo(
            $correos,
            "Pedido pendiente de archivar",
            "PendienteArchivado",
            [
                'referencia' => $pedido->referencia
            ],
            $cc
        );

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
            $descr = "Pedido <a target='_blank' href='" . BASE_URL . "Pedidos/vereditar?id=" . $pedido->id . "'>" . $pedido->referencia . "</a> archivado";
            //$ok = $transaccionesDAO->crear($fecha, $descr, $pedido->areaGastos->id, getCantidadMysql("-" . $pedido->importe));
            $ok = $transaccionesDAO->crear($fecha, $descr, $pedido->areaGastos->id, -$pedido->importe);

            if ($ok) {
                $pedidosDAO->anadir_transaccion($pedidoId, $transaccionesDAO->last_insert);
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

    private function pendienteProveedor(PedidosDAO $pedidosDAO, Pedido $pedido, UsuariosDAO $usuariosDAO)
    {
        $presupuestoSelec = $pedidosDAO->obtener_presupuesto_seleccionado($pedido->id);
        if ($pedido->comprobacion_presupuestos()) {
            if ($presupuestoSelec == null) {
                return [
                    'tipo' => 'danger',
                    'mensaje' => 'Hay que marcar un presupuesto como seleccionado'
                ];
            }
        }

        $pedidosDAO->cambiarEstado($pedido->id, 3);
        $pedidosDAO->rellenarEstado(3, $pedido->id, "Se ha enviado el pedido al proveedor");



        if ($presupuestoSelec != null) {
            $correoProv = $pedido->proveedor->correo;
            $correosAdmin = $usuariosDAO->obtenerCorreosAdmin();
            $correoJD = $pedido->usuario->correo;
            $replyto = [
                $correoJD
            ];


            $archivoUrl = [
                __DIR__ . "/../../public/uploads/presupuestos/" . $pedido->id . "/" . $presupuestoSelec->documento
            ];
            $mailer = new Mailer();
            $mailer->enviarCorreo(
                $correoProv,
                "Envío de presupuesto",
                "PendienteProveedor",
                [
                    'referencia' => $pedido->referencia
                ],
                $correosAdmin,
                $archivoUrl,
                $replyto
            );
        }

    }

    public function pdf($id)
    {
        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");
        $pedido = $pedidosDAO->obtener($id);

        $data = [
            'pedido' => $pedido
        ];

        ob_start();
        $this->view("pedidos/pdf", $data);
        $html = ob_get_clean();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        $footerHtml = '
                        <div style="text-align: right; font-size: 10px;">
                            <img src="static/assets/img/Pedido_pie.png" height="50" alt="Pie de página">
                        </div>
                        ';
        $mpdf->SetHTMLFooter($footerHtml);

        $mpdf->WriteHTML($html);
        $mpdf->Output('pedido_' . $pedido->referencia . '.pdf', 'I');
        exit;
    }

    public function anexo6($id)
    {
        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");
        $pedido = $pedidosDAO->obtener($id);

        $data = [
            'pedido' => $pedido
        ];


        $this->view("pedidos/anexo6", $data);

    }

    public function anexo3($id)
    {
        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");
        $pedido = $pedidosDAO->obtener($id);

        $data = [
            'pedido' => $pedido
        ];


        $this->view("pedidos/anexo3", $data);

    }


    private function guardarDocumentos(PedidosDAO $pedidosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;
        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido.'
            ];
        }
        $pedido = $pedidosDAO->obtener($pedidoId);
        $importe = $pedido->importe;

        // Directorios de uploads
        $path = __DIR__ . "/../../public/uploads/presupuestos/$pedidoId";
        if (!is_dir($path))
            mkdir($path, 0777, true);

        // Presupuestos: 1 o 3
        $insertedPresuID = [];
        $count = $importe >= 1000 ? 3 : 1;
        if ($count == 1) {
            $_POST['presupuesto_seleccionado'] = 1;
        }
        for ($i = 1; $i <= $count; $i++) {
            $field = "presupuesto$i";
            if (isset($_POST['borrar_presupuesto_' . $i])) {
                $presupesto = $pedidosDAO->obtener_presupuesto($_POST['borrar_presupuesto_' . $i]);
                if (file_exists("$path/{$presupesto->documento}")) {
                    safeUnlink("$path/{$presupesto->documento}");
                }
                $pedidosDAO->eliminar_presupuesto($presupesto->id);
            }
            if (!empty($_FILES[$field]['tmp_name'])) {
                // Eliminar físicamente presupuesto existente
                if (isset($_POST[$field . '_current'])) {
                    $presupesto = $pedidosDAO->obtener_presupuesto($_POST[$field . '_current']);
                    if (file_exists("$path/{$presupesto->documento}")) {
                        safeUnlink("$path/{$presupesto->documento}");
                    }
                    $pedidosDAO->eliminar_presupuesto($presupesto->id);
                }

                // Subir nuevo archivo
                $name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $_FILES[$field]['name']);
                move_uploaded_file($_FILES[$field]['tmp_name'], "$path/$name");
                // Reemplazar registro en BD

                $pedidosDAO->insertar_presupuestos([
                    'id_pedido' => $pedidoId,
                    'documento' => $name,
                    'seleccionado' => (!empty($_POST['presupuesto_seleccionado']) && (int) $_POST['presupuesto_seleccionado'] === $i) ? 1 : 0
                ]);
                $insertedPresuID["pres$i"] = $pedidosDAO->last_insert_presupuesto;
            }
        }
        // Cambio de selección sin subir archivo
        if ($count > 1 && !empty($_POST['presupuesto_seleccionado'])) {
            $sel = (int) $_POST['presupuesto_seleccionado'];

            $pedidosDAO->deseleccionar_presupuestos($pedidoId);
            if (isset($insertedPresuID["pres$sel"])) {
                $presid = $insertedPresuID["pres$sel"];
            } else {
                $presid = @$_POST["presupuesto$sel" . "_current"];
            }
            @$pedidosDAO->seleccionar_presupuesto($presid);
        }

        if (isset($_POST['borrar_anexo'])) {
            $existingAnexo = $pedido->anexo;
            if ($existingAnexo && file_exists("$path/$existingAnexo")) {
                safeUnlink("$path/$existingAnexo");
            }
            $pedidosDAO->borrar_anexo($pedidoId);
        } else if ($importe >= 1000 && !empty($_FILES['anexo']['tmp_name'])) {
            // Eliminar físicamente anexo existente
            $existingAnexo = $pedido->anexo;
            if ($existingAnexo && file_exists("$path/$existingAnexo")) {
                safeUnlink("$path/$existingAnexo");
            }
            // Subir nuevo anexo
            $name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $_FILES['anexo']['name']);
            move_uploaded_file($_FILES['anexo']['tmp_name'], "$path/$name");
            $pedidosDAO->insertar_anexo($pedidoId, $name);
        }
        if (isset($_POST['borrar_albaran'])) {
            $existingAlb = $pedido->albaran;
            if ($existingAlb && file_exists("$path/$existingAlb")) {
                safeUnlink("$path/$existingAlb");
            }
            $pedidosDAO->borrar_albaran($pedidoId);
        } else if (!empty($_FILES['albaran']['tmp_name'])) {
            $existingAlb = $pedido->albaran;
            if ($existingAlb && file_exists("$path/$existingAlb")) {
                safeUnlink("$path/$existingAlb");
            }
            // Subir nuevo albarán
            $name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $_FILES['albaran']['name']);
            move_uploaded_file($_FILES['albaran']['tmp_name'], "$path/$name");
            $pedidosDAO->insertar_albaran($pedidoId, $name);
        }

        return ['tipo' => 'success', 'mensaje' => 'Documentos actualizados correctamente.'];
    }

    private function subirFactura(PedidosDAO $pedidosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;
        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido para la factura.'
            ];
        }
        $pedido = $pedidosDAO->obtener($pedidoId);

        // Validar campos obligatorios
        $referencia = trim($_POST['referencia'] ?? '');
        $fechaFactura = $_POST['fecha_factura'] ?? null;
        if ($referencia === '' || !$fechaFactura) {
            return [
                'tipo' => 'warning',
                'mensaje' => 'Debe indicar número y fecha de factura.'
            ];
        }

        if (!$pedidosDAO->comprobar_referencia($referencia, $pedido->factura->id)) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Ya existe una factura con esa referencia en la paltaforma.'
            ];
        }

        $pathFact = __DIR__ . "/../../public/uploads/presupuestos/$pedidoId";
        if (!is_dir($pathFact)) {
            mkdir($pathFact, 0777, true);
        }

        // Eliminar factura existente si se sube un nuevo archivo
        if (!empty($_FILES['factura']['tmp_name'])) {
            $existing = $pedido->factura;
            if ($existing && $pedido->factura->id != 0 && file_exists("$pathFact/{$existing->documento}")) {
                safeUnlink("$pathFact/{$existing->documento}");
            }
            // Subir archivo
            $name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $_FILES['factura']['name']);
            move_uploaded_file($_FILES['factura']['tmp_name'], "$pathFact/$name");
        } else {
            // Si no se sube archivo nuevo, mantener nombre antiguo
            $existing = $pedido->factura;
            $name = $existing->documento ?? null;
        }

        // Insertar o actualizar en BD
        if ($pedido->factura->id != 0) {
            $pedidosDAO->actualizar_factura(
                $pedido->factura->id,
                $referencia,
                $fechaFactura,
                $name
            );
        } else {
            $pedidosDAO->insertar_factura(
                $pedidoId,
                $referencia,
                $fechaFactura,
                $name
            );
        }
        $pedidosDAO->rellenarEstado($pedido->estado->id, $pedido->id, "Se ha adjuntado una factura");

        return ['tipo' => 'success', 'mensaje' => 'Factura actualizada correctamente.'];
    }

    private function subirOtroDoc(PedidosDAO $pedidosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;
        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido para la factura.'
            ];
        }
        $pedido = $pedidosDAO->obtener($pedidoId);

        $tipo = $_POST['tipo'] ?? null;
        if (!$tipo && !empty($tipo)) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta añadir el tipo de documento'
            ];
        }

        $path = __DIR__ . "/../../public/uploads/otros/$pedidoId";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        if (!empty($_FILES['archivo']['tmp_name'])) {
            // Subir archivo
            $name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], "$path/$name");
            $pedidosDAO->subir_otro_doc($pedidoId, $tipo, $name);
            $pedidosDAO->rellenarEstado($pedido->estado->id, $pedido->id, "Se ha adjuntado un documentto");
        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => 'No se ha añadido ningún documento'
            ];
        }

        return ['tipo' => 'success', 'mensaje' => 'Documento subido correctamente.'];
    }

    private function borrarOtrosDoc(PedidosDAO $pedidosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;
        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido para la factura.'
            ];
        }
        $pedido = $pedidosDAO->obtener($pedidoId);

        $docs = $_POST['docs'] ?? null;
        if (!$docs || count($docs) == 0) {
            return [
                'tipo' => 'warning',
                'mensaje' => 'No se ha seleccionado ningún archivo.'
            ];
        }

        foreach ($docs as $d) {
            $doc = $pedidosDAO->obtener_otro_doc($d);
            safeUnlink(__DIR__ . '/../../public/uploads/otros/' . $pedido->id . '/' . $doc['documento']);
            $pedidosDAO->borrar_otro_doc($d);
        }

        $pedidosDAO->rellenarEstado($pedido->estado->id, $pedido->id, "Se han borrado documentos");
        return ['tipo' => 'success', 'mensaje' => 'Se han borrado los documentos correctamente'];
    }

    private function borrarFactura(PedidosDAO $pedidosDAO)
    {
        $pedidoId = $_POST['id'] ?? null;
        if (!$pedidoId) {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Falta la id del pedido para la factura.'
            ];
        }
        $pedido = $pedidosDAO->obtener($pedidoId);
        if ($pedido->factura->id == 0) {
            return [
                'tipo' => 'warning',
                'mensaje' => 'Ho hay factura asociada a este pedido.'
            ];
        }
        $pathFact = __DIR__ . "/../../public/uploads/presupuestos/$pedidoId";
        if (file_exists("$pathFact/{$pedido->factura->documento}")) {
            safeUnlink("$pathFact/{$pedido->factura->documento}");
        }
        $pedidosDAO->rellenarEstado($pedido->estado->id, $pedido->id, "Se ha borrado la factura adjunta");
        if ($pedidosDAO->borrar_factura($pedido->factura->id)) {
            return [
                'tipo' => 'success',
                'mensaje' => 'Factura borrada correctamente.'
            ];
        } else {
            return [
                'tipo' => 'warning',
                'mensaje' => 'Ha sucedido un error al borrar la factura.'
            ];
        }
    }

    private function borrar(PedidosDAO $pedidosDAO, TransaccionesDAO $transaccionesDAO)
    {
        $id = $_POST['id'];
        $confirmacion = $_POST['confirmacion'];

        if ($confirmacion != "Borrar") {
            return [
                'tipo' => 'warning',
                'mensaje' => 'El campo de confirmación no coincide'
            ];
        }

        $pedido = $pedidosDAO->obtener($id);


        if (!is_null($pedido->anexo)) {
            safeUnlink(__DIR__ . "/../../public/uploads/presupuestos/" . $pedido->id . "/" . $pedido->anexo);
        }

        if (!is_null($pedido->albaran)) {
            safeUnlink(__DIR__ . "/../../public/uploads/presupuestos/" . $pedido->id . "/" . $pedido->albaran);
        }

        if ($pedido->factura->id != 0) {
            safeUnlink(__DIR__ . "/../../public/uploads/presupuestos/" . $pedido->id . "/" . $pedido->factura->documento);
            $pedidosDAO->borrar_factura($pedido->factura->id);
        }

        $presupuestos = $pedidosDAO->obtener_presupuestos($pedido->id);
        foreach ($presupuestos as $p) {
            safeUnlink(__DIR__ . "/../../public/uploads/presupuestos/" . $pedido->id . "/" . $p->documento);
            $pedidosDAO->borrar_presupuesto($p->id);
        }


        $random = random_int(1, 99999999);
        $ref = "Borrado$random";

        if ($pedido->transaccion->id != 0) {
            $transaccionesDAO->borrar($pedido->transaccion->id, $ref);
        }


        if ($pedidosDAO->borrar($id, $ref)) {

            return [
                'tipo' => 'success',
                'mensaje' => 'Se ha borrado el pedido correctamente'
            ];



        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Ha sucedido un problema al borrar el pedido'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }


}