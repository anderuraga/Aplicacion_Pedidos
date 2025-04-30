<?php
require_once __DIR__ . '/../helpers/auth.php';

class ProveedoresController extends Controller
{
    public function index()
    {
        $ProveedoresDAO = $this->dao("Proveedores");
        $proveedores = $ProveedoresDAO->listar();

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
                tipo_servicio_id: 0,
                tipo_servicio_nombre: ''
            );
        }

        $tiposServicioDAO = $this->dao("TiposServicio");
        $tiposservicio = $tiposServicioDAO->listar();

        $this->view("proveedores/formulario", ['proveedor' => $proveedor, 'tiposservicio' => $tiposservicio]);

    }

    public function guardar($proveedoresDAO)
    {
        //TODO manejar archivos subidos
        $id = (int) ($_POST['id']);
        $cif = trim($_POST['cif']);
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

        if (
            $cif === '' || $nombre === '' || $direccion === '' ||
            $cod_postal <= 0 || $poblacion === '' || $provincia === '' ||
            $pais === '' || $telefono === '' || $correo === '' ||
            $cuenta_bancaria === '' || $contacto === '' || $id_servicio === 0
        ) {
            return [
                'tipo' => 'warning',
                'mensaje' => 'Todos los campos obligatorios deben rellenarse correctamente.'
            ];
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
            'id_servicio' => $id_servicio
        ];

        if ($id === 0) {
            $ok = $proveedoresDAO->crear($data);
        } else {
            $ok = $proveedoresDAO->editar($id, $data);
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
        return requireAdmin();
    }
}