<?php
require_once __DIR__ . '/../helpers/auth.php';

class DepartamentosController extends Controller
{
    public function index()
    {
        $departamentosDAO = $this->dao("Departamentos");
        $departamentos = $departamentosDAO->listar();

        $this->view("departamentos/index", ['departamentos' => $departamentos]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $departamentosDAO = $this->dao("Departamentos");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] == "borrar") {
                $_SESSION['alert'] = $this->borrar($departamentosDAO);
                if ($_SESSION['alert']['tipo'] == "success") {
                    session_write_close();
                    header("Location: " . BASE_URL . "Departamentos");
                    exit;
                }
            } else {
                $_SESSION['alert'] = $this->guardar($departamentosDAO);
                if ($departamentosDAO->last_insert != null) {
                    session_write_close();
                    header("Location: vereditar?id=" . $departamentosDAO->last_insert);
                }
            }

        }


        if ($id <> 0) {
            $departamento = $departamentosDAO->obtener($id);
        } else {
            $departamento = new Departamento(0, '');
        }

        $this->view("departamentos/formulario", ['departamento' => $departamento]);

    }

    public function guardar($departamentoDAO)
    {

        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del area de gasto no puede estar vacío."
            ];
        }

        if ($id != 0 && !$departamentoDAO->comprobarId($id)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "El departamento no existe."
            ];
        }

        if ($departamentoDAO->comprobrarNombre($nombre, $id)) {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del adepartamento ya existe."
            ];
        }

        if ($id == 0) {
            $ok = $departamentoDAO->crear($nombre);
        } else {
            $ok = $departamentoDAO->editar($id, $nombre);
        }

        if ($ok) {
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha creado el departamento correctamente' : 'Se ha editado el departamento correctamente'
            ];
        } else {
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear el departamento' : 'No se ha podido editar el departamento'
            ];
        }
    }

    private function borrar(DepartamentosDAO $departamentosDAO)
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

        if ($departamentosDAO->borrar($id, $nombre)) {
            return [
                'tipo' => 'success',
                'mensaje' => 'Se ha borrado el departamento correctamente'
            ];
        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Ha sucedido un problema al borrar el departamento'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireAdmin();
    }
}