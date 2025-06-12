<?php
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/Mailer.php';

class InventarioController extends Controller
{
    public function index()
    {
        global $usuario;
        /**
         * @var ItemsDAO
         */
        $itemsDAO = $this->dao("Items");

        if ($usuario->tipo == ADMIN) {
            $items = $itemsDAO->listar();
        } else {
            $items = $itemsDAO->listar_departamento($usuario->departamento->id);
        }


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
            header('Location: ' . BASE_URL . 'AreasGastos');
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
        /**
         * @var ItemsDAO
         */
        $itemsDAO = $this->dao("Items");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**
             * @var UsuariosDAO
             */
            $usuariosDAO = $this->dao("Usuarios");
            /**
             * @var DepartamentosDAO
             */
            $departamentosDAO = $this->dao("Departamentos");
            $_SESSION['alert'] = $this->guardar($itemsDAO, $usuariosDAO, $departamentosDAO);
            if ($itemsDAO->last_insert != null) {
                session_write_close();
                header("Location: vereditar?id=" . $itemsDAO->last_insert);
            }
        }

        if ($id <> 0) {
            $item = $itemsDAO->obtener($id);
        } else {
            $item = new Item(0, new Departamento(0, ''), '', 0);
        }

        $data = [
            'item' => $item,
        ];

        global $usuario;
        if ($usuario->tipo == ADMIN) {
            /**
             * @var DepartamentosDAO
             */
            $departamentosDAO = $this->dao("Departamentos");
            $departamentos = $departamentosDAO->listar();
            $data['departamentos'] = $departamentos;
        }

        $this->view("inventario/formulario", $data);

    }

    public function guardar(ItemsDAO $itemsDAO, UsuariosDAO $usuariosDAO, DepartamentosDAO $departamentosDAO)
    {
        global $usuario;

        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);

        if ($usuario->tipo == ADMIN) {
            $departamento = $_POST['departamento'];
        } else {
            $departamento = $usuario->departamento->id;
        }


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
            $ok = $itemsDAO->crear($nombre, $departamento);
            $departamentoVO = $departamentosDAO->obtener($departamento);
            $correos = $usuariosDAO->obtenerCorreosAdmin();
            $mailer = new Mailer();
            $mailer->enviarCorreo(
                $correos,
                "Nuevo Item",
                "NuevoItem",
                [
                    'item' => $nombre,
                    'departamento' => $departamentoVO->nombre
                ]
            );
        } else {
            $ok = $itemsDAO->editar($id, $nombre, $departamento);
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
            /**
             * @var ItemsDAO
             */
            $itemsDAO = $this->dao("Items");
            /**
             * @var UsuariosDAO
             */
            $usuariosDAO = $this->dao("Usuarios");
            $_SESSION['alert'] = $this->guardarMovimiento($movimientosDAO, $itemsDAO,$usuariosDAO);
            if ($movimientosDAO->last_insert != null) {
                session_write_close();
                header("Location: movimiento?id=" . $movimientosDAO->last_insert . "&item=" . $_POST['item_id']);
            }
        }

        if ($id <> 0) {
            $movimiento = $movimientosDAO->obtener($id);
        } else {
            $movimiento = new Movimiento(id: 0, item: new Item(0, new Departamento(0, ''), '', 0), fecha: '', descripcion: '', cantidad: 0);
        }

        $this->view("inventario/movimientos", ['movimiento' => $movimiento]);

    }

    public function guardarMovimiento(MovimientosDAO $movimientosDAO, ItemsDAO $itemsDAO, UsuariosDAO $usuariosDAO)
    {
        $id = (int) ($_POST['id']);
        $tipo = $_POST['tipo'] ?? '';
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
            $correos = $usuariosDAO->obtenerCorreosAdmin();

            $item = $itemsDAO->obtener($item_id);

            $mailer = new Mailer();
            $mailer->enviarCorreo(
                $correos,
                "Nuevo Movimiento en Inventario",
                "NuevoMovimiento",
                [
                    'item' => $item->nombre,
                    'departamento' => $item->departamento->nombre,
                    'cambio' => $cantidad,
                    'total' => $item->cantidad,
                    'descripcion' => $descripcion
                ]
            );
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
        return requireLogin();
    }
}