<?php 
require_once __DIR__.'/../helpers/auth.php';

class TiposServicioController extends Controller {
    public function index() {

        $tiposServicioDAO = $this->dao("TiposServicio");
        $tiposservicio = $tiposServicioDAO->listar();

        $this->view("tiposservicio/index",['tiposservicio' => $tiposservicio]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $tiposServicioDAO = $this->dao("TiposServicio");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['alert'] = $this->guardar($tiposServicioDAO);
            if($tiposServicioDAO->last_insert!=null){
                session_write_close();
                header("Location: vereditar?id=".$tiposServicioDAO->last_insert);
            }
        }
        

        if ($id <> 0) {
            $tiposervicio = $tiposServicioDAO->obtener($id);
        } else {
            $tiposervicio = new TipoServicio(0, '');
        }

        $this->view("TiposServicio/formulario", ['tiposervicio' => $tiposervicio]);

    }

    public function guardar($tiposservicioDAO)
    {

        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del tipo de servicio no puede estar vacío."
            ];
        }

        if ($tiposservicioDAO->comprobrarNombre($nombre, $id)) {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del tipo de servicio ya existe."
            ];
        }

        if ($id == 0) {
            $ok = $tiposservicioDAO->crear($nombre);
        } else {
            $ok = $tiposservicioDAO->editar($id, $nombre);
        }

        if($ok){
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha creado el tipo de servio correctamente' : 'Se ha editado el tipo de servicio correctamente'
            ];
        }else{
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear el tipo de servicio' : 'No se ha podido editar el tipo de servicio'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool {
        return requireAdmin();
    }
}