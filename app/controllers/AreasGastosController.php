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

    public function crear()
    {
        requireAdmin();

        header('Content-Type: application/json');

        $id_departamento = $_POST['departamento'];
        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'El nombre del departamento no puede estar vacío.'
            ]);
            return;
        }

        $departamentosDAO = $this->dao("Departamentos");

        if (!$departamentosDAO->comprobarId($id_departamento)) {
            echo json_encode([
                'resultado' => false,
                'message' => 'El departamento no existe.'
            ]);
            return;
        }

        $areasGastosDAO = $this->dao("AreasGastos");

        if ($areasGastosDAO->comprobrarNombre($nombre)) {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'El nombre del departamento ya existe.'
            ]);
            return;
        }

        $nuevoId = $areasGastosDAO->crear($nombre, $id_departamento);

        if ($nuevoId) {
            echo json_encode([
                'resultado' => true,
                'message' => 'Área de gasto creada correctamente.',
                'id' => $nuevoId
            ]);
        } else {
            echo json_encode([
                'resultado' => false,
                'message' => 'Error al crear el área de gasto.'
            ]);
        }

    }


    public function vereditar($idParam = -1)
    {
        requireAdmin();
        $alert = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // The request is using the POST method
            $alert = $this->guardar();
        }

        $id = ($idParam <> -1 ? $idParam : $_GET['id']);


        $departamentosModelo = $this->dao("Departamentos");
        $departamentos = $departamentosModelo->listar();

        $areasGastoModelo = $this->dao("AreasGastos");
        $areaGasto = $areasGastoModelo->obtener($id);

        /*$alert = [
            'tipo' => 'danger',
            'mensaje' => "Esto es una alerta"
        ];*/

        $this->view("areasgastos/formulario", ['areaGasto' => $areaGasto, 'departamentos' => $departamentos, 'alert' => $alert]);

    }

    public function guardar()
    {

        $id = $_POST['id'];
        $id_departamento = $_POST['departamento'];
        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            /* echo json_encode([
                 'resultado' => false,
                 'mensaje' => 'El nombre del departamento no puede estar vacío.'
             ]);
             */
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del departamento no puede estar vacío."
            ];
        }

        $areaGastosDAO = $this->dao("AreasGastos");

        if ($areaGastosDAO->comprobrarNombre($nombre, $id)) {
            /*
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'El nombre del departamento ya existe.'
            ]);
            */
            return [
                'tipo' => 'warning',
                'mensaje' => "El nombre del departamento ya existe."
            ];
        }

        $ok = $areaGastosDAO->editar($id, $nombre, $id_departamento);


        return [
            'tipo' => 'success',
            'mensaje' => "Editado correctamente"
        ];
        /*
        echo json_encode([
            'resultado' => $ok,
            'mensaje' => $ok ? 'Area de gastos editada con éxito.' : 'Error al editar el area de gastos.'
        ]);
        */
        //$this->vereditar($id);

    }

    public function editarAjax()
    {
        requireAdmin();

        header('Content-Type: application/json');

        $id = $_POST['id'];
        $id_departamento = $_POST['departamento'];
        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'El nombre del departamento no puede estar vacío.'
            ]);
            return;
        }

        $areaGastosDAO = $this->dao("AreasGastos");

        if ($areaGastosDAO->comprobrarNombre($nombre, $id)) {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'El nombre del departamento ya existe.'
            ]);
            return;
        }

        $ok = $areaGastosDAO->editar($id, $nombre, $id_departamento);

        echo json_encode([
            'resultado' => $ok,
            'mensaje' => $ok ? 'Area de gastos editada con éxito.' : 'Error al editar el area de gastos.'
        ]);

    }
}