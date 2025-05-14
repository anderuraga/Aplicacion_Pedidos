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
            $_SESSION['alert'] = $this->guardar($transaccionesDAO,$areasGastosDAO);
            if($transaccionesDAO->last_insert!=null){
                session_write_close();
                header("Location: vereditar?id=".$transaccionesDAO->last_insert);
            }
        }

        $areasgastos = $areasGastosDAO->listar();

        if ($id <> 0) {
            $ingreso = $transaccionesDAO->obtener($id);
        } else {
            require_once __DIR__ . "/../models/vo/AreaGastos.php";
            $ingreso = new Transaccion(0, new AreaGastos(0,'',new Departamento(0,''),'','','',''), '', '', '');
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

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireAdmin();
    }
}