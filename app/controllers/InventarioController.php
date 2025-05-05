<?php
require_once __DIR__ . '/../helpers/auth.php';

class InventarioController extends Controller
{
    public function index()
    {

        $itemsDAO = $this->dao("Items");
        $items = $itemsDAO->listar();

        $this->view("inventario/index", ['items' => $items]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $itemsDAO = $this->dao("Items");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['alert'] = $this->guardar($itemsDAO);
            if ($itemsDAO->last_insert != null) {
                session_write_close();
                header("Location: vereditar?id=" . $itemsDAO->last_insert);
            }
        }


        if ($id <> 0) {
            $item = $itemsDAO->obtener($id);
        } else {
            $item = new Item(0, '', 0);
        }

        $this->view("inventario/formulario", ['item' => $item]);

    }

    public function guardar($itemsDAO)
    {

        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del item no puede estar vacío."
            ];
        }

        if ($id != 0 && !$itemsDAO->comprobarId($id)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "El item no existe."
            ];
        }

        if ($itemsDAO->comprobrarNombre($nombre, $id)) {
            return [
                'tipo' => 'warning',
                'mensaje' => "Un item con el mismo nombre ya existe."
            ];
        }

        if ($id == 0) {
            $ok = $itemsDAO->crear($nombre);
        } else {
            $ok = $itemsDAO->editar($id, $nombre);
        }

        if ($ok) {
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha creado el item correctamente' : 'Se ha editado el item correctamente'
            ];
        } else {
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear el item' : 'No se ha podido editar el item'
            ];
        }
    }

    public function tiene_permiso(): bool
    {
        return requireAdmin();
    }
}