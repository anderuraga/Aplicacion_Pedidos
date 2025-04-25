<?php 
require_once __DIR__.'/../helpers/auth.php';

class UsuariosController extends Controller {
    public function index() {
        $usuariosDAO = $this->dao("Usuarios");
        $usuarios = $usuariosDAO->listar();
        
        $this->view("usuarios/index",['usuarios' => $usuarios]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $usuariosDAO = $this->dao("Usuarios");
        $departamentosDAO = $this->dao("Departamentos");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['alert'] = $this->guardar($usuariosDAO,$departamentosDAO);
            if($usuariosDAO->last_insert!=null){
                session_write_close();
                header("Location: vereditar?id=".$usuariosDAO->last_insert);
            }
        }
        
        $departamentos = $departamentosDAO->listar();

        if ($id <> 0) {
            $usuario = $usuariosDAO->obtener($id);
        } else {
            require_once __DIR__ . "/../models/vo/AreaGastos.php";
            $usuario = new Usuario(0, 0, '', '',0,'');
        }

        $this->view("usuarios/formulario", ['usuario' => $usuario, 'departamentos' => $departamentos]);

    }

    public function guardar($usuariosDAO,$departamentoDAO)
    {

        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $departamentoID = $_POST['departamento'];

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

        if (!$departamentoDAO->comprobarId($departamentoID)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "El departamento no existe."
            ];
        }

        if ($id!=0 && !$usuariosDAO->obtener($id)) {
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
            $ok = $usuariosDAO->crear($nombre,$correo,$departamentoID);
        } else {
            $ok = $usuariosDAO->editar($id, $nombre,$correo,$departamentoID);
        }

        if($ok){
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha creado el usuario correctamente' : 'Se ha editado el usuario correctamente'
            ];
        }else{
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear el usuario' : 'No se ha podido editar el usuario'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool {
        return requireAdmin();
    }
}