<?php
require_once __DIR__ . '/../helpers/auth.php';

class SubconceptosController extends Controller
{
    public function index()
    {
        $SubconceptosDAO = $this->dao("Subconceptos");
        $subconceptos = $SubconceptosDAO->listar();
        $this->view("subconceptos/index", ['subconceptos' => $subconceptos]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];
        $idnuevo = $_POST['idnuevo'] ?? null;
        /**
         * @var SubconceptosDAO
         */
        $subconceptosDAO = $this->dao("Subconceptos");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] == "borrar") {
                $_SESSION['alert'] = $this->borrar($subconceptosDAO);
                if ($_SESSION['alert']['tipo'] == "success") {
                    session_write_close();
                    header("Location: " . BASE_URL . "Subconceptos");
                    exit;
                }
            } else {
                $_SESSION['alert'] = $this->guardar($subconceptosDAO);

                session_write_close();
                header("Location: vereditar?id=" . $idnuevo);
                exit;
            }

        }


        if ($id <> 0) {
            $subconcepto = $subconceptosDAO->obtener($id);
        } else {
            $subconcepto = new Subconcepto(0, '');
        }

        $this->view("subconceptos/formulario", ['subconcepto' => $subconcepto]);

    }

    public function guardar(SubconceptosDAO $subconceptosDAO)
    {

        $id = $_POST['id'];
        $idnuevo = $_POST['idnuevo'] ?? null;

        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del area de gasto no puede estar vacío."
            ];
        }

        if ($id != 0 && !$subconceptosDAO->comprobarId($id)) {
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
            $ok = $subconceptosDAO->crear($idnuevo, $nombre);
        } else {
            $ok = $subconceptosDAO->editar($id, $idnuevo, $nombre);
        }

        if ($ok) {
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha creado el subconcepto correctamente' : 'Se ha editado el subconcepto correctamente'
            ];
        } else {
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear el subconcepto' : 'No se ha podido editar el subconcepto'
            ];
        }
    }

    private function borrar(SubconceptosDAO $subconceptosDAO)
    {
        $id = $_POST['id'];
        $confirmacion = $_POST['confirmacion'];

        if ($confirmacion != "Borrar") {
            return [
                'tipo' => 'warning',
                'mensaje' => 'El campo de confirmación no coincide'
            ];
        }

        $random = random_int(1, 99999999);
        $nombre = "Borrado$random";

        if ($subconceptosDAO->borrar($id, $nombre)) {
            return [
                'tipo' => 'success',
                'mensaje' => 'Se ha borrado el subconcepto correctamente'
            ];
        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Ha sucedido un problema al borrar el subconcepto'
            ];
        }
    }


    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireAdmin();
    }
}