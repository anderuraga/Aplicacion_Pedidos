<?php
require_once __DIR__ . '/../helpers/auth.php';

class ProveedoresController extends Controller
{
    public function index()
    {
        global $usuario;

        $ProveedoresDAO = $this->dao("Proveedores");
        if ($usuario->tipo == ADMIN) {
            $proveedores = $ProveedoresDAO->listar();
        } else {
            $proveedores = $ProveedoresDAO->listar_usuario($usuario->id);
        }

        $this->view("proveedores/index", ['proveedores' => $proveedores]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $proveedoresDAO = $this->dao("Proveedores");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['alert'] = $this->guardar($proveedoresDAO);
            if ($proveedoresDAO->last_insert !== null) {
                session_write_close();
                header("Location: vereditar?id=" . $proveedoresDAO->last_insert);
                exit;
            }
        }

        if ($id <> 0) {
            $proveedor = $proveedoresDAO->obtener($id);
        } else {
            $proveedor = new Proveedor(
                id: 0,
                cif: '',
                nombre: '',
                direccion: '',
                cod_postal: 0,
                poblacion: '',
                provincia: '',
                pais: '',
                telefono: '',
                correo: '',
                factura_electronica: false,
                cuenta_bancaria: '',
                contacto: '',
                tipoServicio: new TipoServicio(0, ''),
                gasto_anual: 0,
                terceros: null,
                prov_prof: null,
                fecha_baja: null,
                limite: GASTO_FROVEEDOR,
                fecha_creado: '',
                fecha_editado: '',
                usuario: new Usuario(0, 0, '', '', new Departamento(0, ''))
            );
        }

        $tiposServicioDAO = $this->dao("TiposServicio");
        $tiposservicio = $tiposServicioDAO->listar();

        $this->view("proveedores/formulario", ['proveedor' => $proveedor, 'tiposservicio' => $tiposservicio]);

    }

    public function guardar(ProveedoresDAO $proveedoresDAO)
    {
        global $usuario;
        $id = (int) ($_POST['id']);
        $cif = trim(string: $_POST['cif']);
        $nombre = trim($_POST['nombre']);
        $direccion = trim($_POST['direccion']);
        $cod_postal = (int) ($_POST['codpostal']);
        $poblacion = trim($_POST['poblacion']);
        $provincia = trim($_POST['provincia']);
        $pais = trim($_POST['pais']);
        $telefono = trim($_POST['telefono']);
        $correo = trim($_POST['mail']);
        $factura_electronica = isset($_POST['facturaElectronica']) ? 1 : 0;
        $cuenta_bancaria = trim($_POST['cuenta_bancaria']);
        $contacto = trim($_POST['contacto']);
        $id_servicio = (int) ($_POST['tipoServicio'] ?? 0);

        $requiredFields = [
            'cif' => 'CIF',
            'nombre' => 'Nombre',
            'direccion' => 'Dirección',
            'cod_postal' => 'Código Postal',
            'poblacion' => 'Población',
            'provincia' => 'Provincia',
            'pais' => 'País',
            'telefono' => 'Teléfono',
            'correo' => 'Correo',
            'cuenta_bancaria' => 'Cuenta bancaria',
            'contacto' => 'Contacto',
            'id_servicio' => 'Servicio'
        ];

        foreach ($requiredFields as $varName => $label) {
            $value = $$varName;

            if (
                ($varName === 'cod_postal' && intval($value) <= 0)
                || ($varName === 'id_servicio' && intval($value) === 0)
                || ($varName !== 'cod_postal' && $varName !== 'id_servicio' && trim($value) === '')
            ) {
                return [
                    'tipo' => 'warning',
                    'mensaje' => "El campo «{$label}» no ha sido rellenado correctamente."
                ];
            }
        }

        if ($proveedoresDAO->comprobrarCif($cif, $id ?: null)) {
            return [
                'tipo' => 'warning',
                'mensaje' => "Ya existe un proveedor con ese CIF."
            ];
        }

        $data = [
            'cif' => $cif,
            'nombre' => $nombre,
            'direccion' => $direccion,
            'cod_postal' => $cod_postal,
            'poblacion' => $poblacion,
            'provincia' => $provincia,
            'pais' => $pais,
            'telefono' => $telefono,
            'correo' => $correo,
            'factura_e' => $factura_electronica,
            'cuenta_bancaria' => $cuenta_bancaria,
            'contacto' => $contacto,
            'id_servicio' => $id_servicio,
            'usuario_id' => $usuario->id,
        ];

        if ($id === 0) {
            $ok = $proveedoresDAO->crear($data);
        } else {
            $ok = $proveedoresDAO->editar($id, $data);
        }

        if (!empty($_FILES["alta_terceros"]['tmp_name'])) {
            $proveedorID = $id == 0 ? $proveedoresDAO->last_insert : $id;
            $proveedor = $proveedoresDAO->obtener($proveedorID);
            $rutaBase = __DIR__ . "/../../public/uploads/proveedor/$proveedorID/terceros";
            if (!is_dir($rutaBase)) {
                mkdir($rutaBase, 0777, true);
            }

            if ($proveedor->terceros != null) {
                unlink($rutaBase . "/" . $proveedor->terceros);
            }

            $original = $_FILES["alta_terceros"]['name'];
            $nombreLimpio = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $original);
            $rutaFinal = "$rutaBase/$nombreLimpio";

            if (move_uploaded_file($_FILES["alta_terceros"]['tmp_name'], $rutaFinal)) {
                $ok = $proveedoresDAO->insertar_alta_terceros($proveedorID, $nombreLimpio);
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

        if (!empty($_FILES["proveedor_profesor"]['tmp_name'])) {
            $proveedorID = $id == 0 ? $proveedoresDAO->last_insert : $id;
            $rutaBase = __DIR__ . "/../../public/uploads/proveedor/$proveedorID/proveedor_profesor";
            if (!is_dir($rutaBase)) {
                mkdir($rutaBase, 0777, true);
            }

            if ($proveedor->prov_prof != null) {
                unlink($rutaBase . "/" . $proveedor->prov_prof);
            }

            $original = $_FILES["proveedor_profesor"]['name'];
            $nombreLimpio = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $original);
            $rutaFinal = "$rutaBase/$nombreLimpio";

            if (move_uploaded_file($_FILES["proveedor_profesor"]['tmp_name'], $rutaFinal)) {
                $ok = $proveedoresDAO->insertar_proveedor_profesor($proveedorID, $nombreLimpio);
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

        if ($ok) {
            return [
                'tipo' => 'success',
                'mensaje' => $id === 0
                    ? 'Proveedor creado correctamente.'
                    : 'Proveedor editado correctamente.'
            ];
        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => $id === 0
                    ? 'Error al crear el proveedor.'
                    : 'Error al editar el proveedor.'
            ];
        }


    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }
}