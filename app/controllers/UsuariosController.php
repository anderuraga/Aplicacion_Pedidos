<?php
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/Mailer.php';

class UsuariosController extends Controller
{
    public function index()
    {
        $usuariosDAO = $this->dao("Usuarios");
        $usuarios = $usuariosDAO->listar();

        $this->view("usuarios/index", ['usuarios' => $usuarios]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $usuariosDAO = $this->dao("Usuarios");
        $departamentosDAO = $this->dao("Departamentos");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['alert'] = $this->guardar($usuariosDAO, $departamentosDAO);
            if ($usuariosDAO->last_insert != null) {
                session_write_close();
                header("Location: vereditar?id=" . $usuariosDAO->last_insert);
            }
        }

        $departamentos = $departamentosDAO->listar();

        if ($id <> 0) {
            $usuario = $usuariosDAO->obtener($id);
        } else {
            require_once __DIR__ . "/../models/vo/AreaGastos.php";
            $usuario = new Usuario(0, 0, '', '', new Departamento(0, ''));
        }


        $this->view("usuarios/formulario", ['usuario_form' => $usuario, 'departamentos' => $departamentos]);

    }

    public function guardar(UsuariosDAO $usuariosDAO, DepartamentosDAO $departamentoDAO)
    {

        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $departamentoID = $_POST['departamento'];
        $tipo = $_POST['tipo'];
        $contrasena = null;
        if (isset($_POST['contrasena']) && $_POST['contrasena'] != '') {
            $contrasena = $_POST['contrasena'];
        }

        if ($nombre === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del usuario no puede estar vacío."
            ];
        }

        if ($correo === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "El correo del usuario no puede estar vacío."
            ];
        }

        if ($id == 0 && ($contrasena == null || strlen($contrasena) == 0)) {
            return [
                'tipo' => 'warning',
                'mensaje' => "La contraseña no puede estar vacia al crear un usuario."
            ];
        }

        if ($contrasena != null && strlen($contrasena) < 8) {
            return [
                'tipo' => 'warning',
                'mensaje' => "La contraseña debe tener 8 caracteres como mínimo."
            ];
        }

        if (!$departamentoDAO->comprobarId($departamentoID)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "El departamento no existe."
            ];
        }

        if ($id != 0 && !$usuariosDAO->obtener($id)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "El usuario no existe."
            ];
        }

        if ($usuariosDAO->comprobarCorreo($correo, $id)) {
            return [
                'tipo' => 'warning',
                'mensaje' => "Existe una cuenta registrada que utiliza ese correo."
            ];
        }

        if ($id == 0) {
            $ok = $usuariosDAO->crear($nombre, $correo, $departamentoID, $tipo, $contrasena);
        } else {
            $ok = $usuariosDAO->editar($id, $nombre, $correo, $departamentoID, $tipo, $contrasena);
        }

        if ($ok) {
            if ($id == 0) {
                $mailer = new Mailer();
                $mailer->enviarCorreo(
                    $correo,
                    "Usuario dado de alta",
                    "NuevoUsuario",
                    [
                        'contrasena' => $contrasena,
                    ]
                );
            }
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha creado el usuario correctamente' : 'Se ha editado el usuario correctamente'
            ];
        } else {
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear el usuario' : 'No se ha podido editar el usuario'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireAdmin();
    }
}