<?php
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/formatos.php';

class AreasGastosController extends Controller
{
    public function index()
    {
        //TODO ls seguirdad en App
        requireAdmin();

        $departamentosModelo = $this->dao("Departamentos");
        $departamentos = $departamentosModelo->listar();

        $areasGastoModelo = $this->dao("AreasGastos");
        $areasGastos = $areasGastoModelo->listar();

        $transaccionDAO = $this->dao("Transacciones");

        //TODO crear view con los datos
        foreach ($areasGastos as &$area) {
            $resumen = $transaccionDAO->resumenPorArea($area->id);
            $area->ingresos = getCantidadFormateada($resumen['ingresos']) . "€";
            $area->gastos = getCantidadFormateada($resumen['gastos']) . "€";
            $area->diferencia = getCantidadFormateada($resumen['diferencia']) . "€";
        }

        $this->view("areasgastos", ['areasGastos' => $areasGastos, 'departamentos' => $departamentos]);
    }

    public function historial($id)
    {
        requireAdmin();

        $AreasGastosModelo = $this->model("AreaGastos");
        if (!$AreasGastosModelo->comprobarId($id)) {
            die("Área de gasto no encontrada.");
        }

        $area = $AreasGastosModelo->obtener($id);

        $this->view("areagastoshistorial", [
            'area' => $area
        ]);
    }

    public function vereditar()
    {
        requireAdmin();
        $alert = null;

        $id = $_GET['id'];

        $areasGastoDAO = $this->dao("AreasGastos");
        $departamentosDAO = $this->dao("Departamentos");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $alert = $this->guardar($areasGastoDAO,$departamentosDAO);
            $id = $areasGastoDAO->last_insert == null ? $id : $areasGastoDAO->last_insert;
            // FIXME Si se recarga la página después de un crear se vuelve a enviar una petición de crear página
            //       Si se usa un location header para recargar la página arreglamos esto pero perdemos el mensaje de alerta
            //       Se podrií considerar guardar el mensaje de alerta en una variable de sesión pero no se como de correcto es eso
        }
        
        $departamentos = $departamentosDAO->listar();

        if ($id <> 0) {
            
            $areaGasto = $areasGastoDAO->obtener($id);
        } else {
            require_once __DIR__ . "/../models/vo/AreaGastos.php";
            $areaGasto = new AreaGastos(0, '', 0, '');
        }

        $this->view("areasgastos/formulario", ['areaGasto' => $areaGasto, 'departamentos' => $departamentos, 'alert' => $alert]);

    }

    public function guardar($areaGastosDAO,$departamentoDAO)
    {

        $id = $_POST['id'];
        $id_departamento = $_POST['departamento'];
        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del area de gasto no puede estar vacío."
            ];
        }

        if (!$departamentoDAO->comprobarId($id_departamento)) {
            return [
                'tipo' => 'danger',
                'mensaje' => "El departamento no existe."
            ];
        }

        if ($areaGastosDAO->comprobrarNombre($nombre, $id)) {
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del area de gasto ya existe."
            ];
        }

        if ($id == 0) {
            $ok = $areaGastosDAO->crear($nombre, $id_departamento);
        } else {
            $ok = $areaGastosDAO->editar($id, $nombre, $id_departamento);
        }

        if($ok){
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha creado el area de gastos correctamente' : 'Se ha editado el area de gastos correctamente'
            ];
        }else{
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear el departamento' : 'No se ha podido editar el departamento'
            ];
        }
    }
}