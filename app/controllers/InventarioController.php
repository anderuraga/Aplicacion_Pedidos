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

    public function historial()
    {
        $id = $_GET['id'];

        $itemsDAO = $this->dao("Items");
        if (!$itemsDAO->comprobarId($id)) {
            $_SESSION['alert'] = [
                'tipo' => 'warning',
                'mensaje' => "El item no existe."
            ];
            session_write_close();
            header('Location: '.BASE_URL.'AreasGastos');
        }

        $item = $itemsDAO->obtener($id);

        $movimientosDAO = $this->dao("Movimientos");
        $movimientos = $movimientosDAO->listar($id);

        $this->view("inventario/historial", [
            'item' => $item,
            'movimientos' => $movimientos
        ]);
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

    public function movimiento()
    {
        $id = $_GET['id'];

        $movimientosDAO = $this->dao("Movimientos");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['alert'] = $this->guardarMovimiento($movimientosDAO);
            //TODO Averiguar pro que desaparece el segundo parametro al editar en vez de crear
            if($movimientosDAO->last_insert!=null){
                session_write_close();
                header("Location: movimiento?id=".$movimientosDAO->last_insert."&item=".$_POST['item_id']);
            }
        }

        if ($id <> 0) {
            $movimiento = $movimientosDAO->obtener($id);
        } else {
            $movimiento = new Movimiento(id: 0, id_item: 0, id_nombre: '', fecha: '', descripcion: '', cantidad: 0);
        }

        $this->view("inventario/movimientos", ['movimiento' => $movimiento]);

    }

    public function guardarMovimiento($movimientosDAO)
    {

        $id = (int) ($_POST['id']);
        $tipo = $_POST['tipo'];
        $cantidad = (int) ($_POST['cantidad']);
        $fecha = trim($_POST['fecha']);
        $descripcion = trim($_POST['descripcion']);
        $item_id = $_POST['item_id'];

        if ($cantidad <= 0 || $fecha === '' || $descripcion === '' || !in_array($tipo, ['Entrada', 'Salida'])) {
            return [
                'tipo' => 'warning',
                'mensaje' => 'Todos los campos deben completarse correctamente.'
            ];
        }

        if ($tipo === 'Salida') {
            $cantidad *= -1;
        }

        $data = [
            'item_id' => $item_id,
            'cantidad' => $cantidad,
            'fecha' => $fecha,
            'descripcion' => $descripcion
        ];

        if ($id === 0) {
            $ok = $movimientosDAO->crear($data);
        } else {
            $ok = $movimientosDAO->editar($id, $data);
        }

        if ($ok) {
            return [
                'tipo' => 'success',
                'mensaje' => $id === 0 ? 'Movimiento creado correctamente.' : 'Movimiento editado correctamente.'
            ];
        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => $id === 0 ? 'Error al crear el movimiento.' : 'Error al editar el movimiento.'
            ];
        }
    }

    public function tiene_permiso(): bool
    {
        return requireAdmin();
    }
}