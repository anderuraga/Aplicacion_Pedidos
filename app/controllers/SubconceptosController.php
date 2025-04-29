<?php 
require_once __DIR__.'/../helpers/auth.php';

class SubconceptosController extends Controller {
    public function index() {
        $SubconceptosDAO = $this->dao("Subconceptos");
        $subconceptos = $SubconceptosDAO->listar();
        $this->view("subconceptos/index",['subconceptos' => $subconceptos]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $subconceptosDAO = $this->dao("Subconceptos");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['alert'] = $this->guardar($subconceptosDAO);
            if($subconceptosDAO->last_insert!=null){
                session_write_close();
                header("Location: vereditar?id=".$subconceptosDAO->last_insert);
            }
        }
        

        if ($id <> 0) {
            $subconcepto = $subconceptosDAO->obtener($id);
        } else {
            $subconcepto = new Subconcepto(0, '','Fungible');
        }

        $this->view("subconceptos/formulario", ['subconcepto' => $subconcepto]);

    }

    public function guardar($subconceptosDAO)
    {

        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);
        $tipo = trim($_POST['tipo']);

        if ($nombre === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del area de gasto no puede estar vacío."
            ];
        }

        if ($id!=0 && !$subconceptosDAO->comprobarId($id)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "El subconcepto no existe."
            ];
        }

        if ($subconceptosDAO->comprobrarNombre($nombre, $id)) {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del subconcepto ya existe."
            ];
        }

        if ($id == 0) {
            $ok = $subconceptosDAO->crear($nombre,$tipo);
        } else {
            $ok = $subconceptosDAO->editar($id, $nombre,$tipo);
        }

        if($ok){
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha creado el subconcepto correctamente' : 'Se ha editado el subconcepto correctamente'
            ];
        }else{
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear el subconcepto' : 'No se ha podido editar el subconcepto'
            ];
        }
    }


    #[\Override]
    public function tiene_permiso(): bool {
        return requireAdmin();
    }
}