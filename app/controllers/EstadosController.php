<?php 
require_once __DIR__.'/../helpers/auth.php';

class EstadosController extends Controller {
    public function index()
    {
        $estadosDAO = $this->dao("Estados");
        $estados = $estadosDAO->listar();

        $this->view("estados/index", ['estados' => $estados]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $estadosDAO = $this->dao("Estados");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['alert'] = $this->guardar($estadosDAO);
        }
        
        $estado = $estadosDAO->obtener($id);
        
        $this->view("estados/formulario", ['estado' => $estado]);

    }

    public function guardar($departamentoDAO)
    {
        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);
        $icono = trim($_POST['icono']);

        if ($nombre === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del estado no puede estar vacío."
            ];
        }

        if ($departamentoDAO->comprobrarNombre($nombre, $id)) {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del estado ya existe."
            ];
        }

        $ok = $departamentoDAO->editar($id, $nombre, $icono);
        
        if($ok){
            return [
                'tipo' => 'success',
                'mensaje' => 'Se ha editado el estado correctamente'
            ];
        }else{
            return [
                'tipo' => 'warning',
                'mensaje' => 'No se ha podido editar el estado'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool {
        return requireAdmin();
    }
}