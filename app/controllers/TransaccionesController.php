<?php 
require_once __DIR__.'/../helpers/auth.php';

class TransaccionesController extends Controller {

    public function listararea($id) {
        requireAdmin();

        $areasGastosModelo = $this->model("AreaGastos");
        if(!$areasGastosModelo->comprobarId($id)){
            die("Área de gasto no encontrada.");
        }

        header('Content-Type: application/json');
        $transaccionModelo = $this->model("Transaccion");
        $transacciones = $transaccionModelo->area($id);

        echo json_encode([
            'success' => true,
            'data' => $transacciones
        ]);
    }
}