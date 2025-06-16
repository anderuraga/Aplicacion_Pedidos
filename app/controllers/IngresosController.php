<?php
require_once __DIR__ . '/../helpers/auth.php';

class IngresosController extends Controller
{
    public function index()
    {

        $transaccionesDAO = $this->dao("Transacciones");
        $ingresos = $transaccionesDAO->ingresos();

        $this->view("ingresos/index", ['ingresos' => $ingresos]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $transaccionesDAO = $this->dao("Transacciones");
        $areasGastosDAO = $this->dao("AreasGastos");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] == "borrar") {
                $_SESSION['alert'] = $this->borrar($transaccionesDAO);
                if ($_SESSION['alert']['tipo'] == "success") {
                    session_write_close();
                    header("Location: " . BASE_URL . "Ingresos");
                    exit;
                }
            } else {
                $_SESSION['alert'] = $this->guardar($transaccionesDAO, $areasGastosDAO);
                if ($transaccionesDAO->last_insert != null) {
                    session_write_close();
                    header("Location: vereditar?id=" . $transaccionesDAO->last_insert);
                    exit;
                }
            }

        }

        $areasgastos = $areasGastosDAO->listar();

        if ($id <> 0) {
            $ingreso = $transaccionesDAO->obtener($id);
        } else {
            require_once __DIR__ . "/../models/vo/AreaGastos.php";
            $ingreso = new Transaccion(0, new AreaGastos(0, '', new Departamento(0, ''), '', '', '', ''), '', '', '', '');
        }

        $this->view("ingresos/formulario", ['ingreso' => $ingreso, 'areasgastos' => $areasgastos]);

    }

    public function guardar($transaccionesDAO, $areasGastosDAO)
    {

        $id = $_POST['id'];
        $fecha = trim($_POST['fecha']);
        $descripcion = trim($_POST['descripcion']);
        $areagasto = trim($_POST['areagasto']);
        $cantidad = getCantidadMysql($_POST['cantidad']);

        if ($descripcion === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "La descripción no puede estar vacia."
            ];
        }

        if ($id != 0 && !$transaccionesDAO->obtener($id)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "La transacción a editar no existe."
            ];
        }

        if (!$areasGastosDAO->comprobarId($areagasto)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "El area de gasto no existe."
            ];
        }


        if ($id == 0) {
            $ok = $transaccionesDAO->crear($fecha, $descripcion, $areagasto, $cantidad);
        } else {
            $ok = $transaccionesDAO->editar($id, $fecha, $descripcion, $areagasto, $cantidad);
        }

        if ($ok) {
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha añadido la transacción correctamente' : 'Se ha editado la transacción correctamente'
            ];
        } else {
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear la transacción' : 'No se ha podido editar la transacción'
            ];
        }
    }

    public function borrar(TransaccionesDAO $transaccionesDAO)
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
        $decripcion = "Borrado $random";

        if ($transaccionesDAO->borrar($id, $decripcion)) {
            return [
                'tipo' => 'success',
                'mensaje' => 'Se ha borrado el ingreso correctamente'
            ];
        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Ha sucedido un problema al borrar el ingreso'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireAdmin();
    }
}