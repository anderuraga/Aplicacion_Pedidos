<?php 
require_once __DIR__.'/../helpers/auth.php';

class IngresosController extends Controller {
    public function index() {
        requireAdmin();

        $modeloAreaGastos = $this->model("AreaGastos");
        $areasGastos = $modeloAreaGastos->listar();

        $this->view("ingresos", ['areasGastos' => $areasGastos]);
    }

    public function listar() {
        requireAdmin();

        header('Content-Type: application/json');
        $modeloTransaccion = $this->model("Transaccion");
        $ingresos = $modeloTransaccion->ingresos();


        echo json_encode([
            'success' => true,
            'data' => $ingresos
        ]);
    }

    public function crear(){
        requireAdmin();

        require_once __DIR__.'/../helpers/formatos.php';

        header('Content-Type: application/json');

        $area = $_POST['areagasto'];
        $fecha = $_POST['fecha'];
        $descripcion = trim($_POST['descripcion']);
        $cantidad = getCantidadFormateada($_POST['cantidad']);

        $modeloAreaGastos = $this->model("AreaGastos");

        if (!$modeloAreaGastos->comprobarId($area)) {
            echo json_encode([
                'success' => false,
                'message' => 'El area de gastos no existe.'
            ]);
            return;
        }

        $modeloTransaccion = $this->model("Transaccion");

        $ok = $modeloTransaccion->crear($area,$fecha,$descripcion,$cantidad);

        echo json_encode([
            'resultado' => $ok,
            'mensaje' => $ok ? 'Ingreso añadido con éxito.' : 'Error al añadir el ingreso.'
        ]);
    }

}