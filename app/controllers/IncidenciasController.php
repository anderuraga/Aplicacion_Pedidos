<?php
require_once __DIR__ . '/../helpers/auth.php';

class IncidenciasController extends Controller
{
    public function index()
    {
        header("Location: " . BASE_URL . "Pedidos");
    }

    public function vereditar()
    {
        

        $id = $_GET['id'];
        if (!isset($id)) {
            $_SESSION['alert'] = [
                'tipo' => 'danger',
                'mensaje' => "No hay id de la incidencia"
            ];
            session_write_close();
            header("Location: " . BASE_URL . "Pedidos");
        }

        if (!isset($_GET['pedido'])) {
            $_SESSION['alert'] = [
                'tipo' => 'danger',
                'mensaje' => "No hay id del pedido"
            ];
            session_write_close();
            header("Location: " . BASE_URL . "Pedidos");
        }
        /**
         * @var IncidenciasDAO
         */
        $incidenciasDAO = $this->dao("Incidencias");

        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");
        $pedido = $pedidosDAO->obtener($_GET['pedido']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['alert'] = $this->guardar($incidenciasDAO);
            if ($incidenciasDAO->last_insert != null) {
                $pedidosDAO->rellenarEstado($pedido->estado->id,$pedido->id,"Nueva incidencia registrada");
                session_write_close();
                header("Location: " . BASE_URL . "Pedidos/vereditar?id=" . $_GET['pedido']);
            }
        }

        global $usuario;
        if ($usuario->tipo != 1) {
            if ($usuario->departamento->id != $pedido->departamento->id) {
                $_SESSION['alert'] = [
                    'tipo' => 'danger',
                    'mensaje' => "No tienes permiso para editar esta incidencia"
                ];
                session_write_close();
                header("Location: " . BASE_URL . "Pedidos");
            }
        }



        if ($id <> 0) {
            $incidencia = $incidenciasDAO->obtener($id);
        } else {
            require_once __DIR__ . "/../models/vo/AreaGastos.php";
            $incidencia = new Incidencia(0, '', '', 0, null);
        }

        $this->view("incidencias/formulario", ['incidencia' => $incidencia, 'pedido' => $pedido]);

    }

    public function guardar(IncidenciasDAO $incidenciasDAO)
    {

        $id = $_POST['id'];
        $pedido = $_POST['pedido'] ?? 0;
        $descripcion = trim($_POST['descripcion'] ?? '');

        if ($descripcion === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "La descripción no puede estar vacia."
            ];
        }

        if ($id != 0 && !$incidenciasDAO->obtener($id)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "La incidencia a editar no existe."
            ];
        }



        if ($id == 0) {
            $ok = $incidenciasDAO->crear($pedido, $descripcion);
        } else {
            $ok = $incidenciasDAO->editar($id, $descripcion);
        }

        if ($ok) {
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha añadido la incidencia correctamente' : 'Se ha editado la incidencia correctamente'
            ];
        } else {
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear la incidencia' : 'No se ha podido editar la incidencia'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }
}