<?php
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/formatos.php';

class AreasGastosController extends Controller
{
    public function index()
    {
        $departamentosModelo = $this->dao("Departamentos");
        $departamentos = $departamentosModelo->listar();

        $areasGastoModelo = $this->dao("AreasGastos");
        $areasGastos = $areasGastoModelo->listar();

        $this->view("areasgastos/index", ['areasGastos' => $areasGastos, 'departamentos' => $departamentos]);
    }

    public function historial()
    {
        $id = $_GET['id'];

        $AreasGastosDAO = $this->dao("AreasGastos");
        if (!$AreasGastosDAO->comprobarId($id)) {
            $_SESSION['alert'] = [
                'tipo' => 'warning',
                'mensaje' => "El are de gasto no existe."
            ];
            session_write_close();
            header('Location: ' . BASE_URL . 'AreasGastos');
        }

        $area = $AreasGastosDAO->obtener($id);

        $transaccionesDAO = $this->dao("Transacciones");
        $transacciones = $transaccionesDAO->transaccionesArea($id);

        $this->view("areasgastos/historial", [
            'area' => $area,
            'transacciones' => $transacciones
        ]);
    }

    public function vereditar()
    {
        $id = $_GET['id'];

        $areasGastoDAO = $this->dao("AreasGastos");
        $departamentosDAO = $this->dao("Departamentos");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] == "borrar") {
                $_SESSION['alert'] = $this->borrar($areasGastoDAO);
                if ($_SESSION['alert']['tipo'] == "success") {
                    session_write_close();
                    header("Location: " . BASE_URL . "AreasGastos");
                    exit;
                }
            } else {
                $_SESSION['alert'] = $this->guardar($areasGastoDAO, $departamentosDAO);
                if ($areasGastoDAO->last_insert != null) {
                    session_write_close();
                    header("Location: vereditar?id=" . $areasGastoDAO->last_insert);
                    exit;
                }
            }

        }

        $departamentos = $departamentosDAO->listar();

        if ($id <> 0) {
            $areaGasto = $areasGastoDAO->obtener($id);
        } else {
            require_once __DIR__ . "/../models/vo/AreaGastos.php";
            $areaGasto = new AreaGastos(0, '', new Departamento(0, ''), '', 0, 0, 0);
        }

        $this->view("areasgastos/formulario", ['areaGasto' => $areaGasto, 'departamentos' => $departamentos]);

    }

    public function guardar($areaGastosDAO, $departamentoDAO)
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

        if ($ok) {
            return [
                'tipo' => 'success',
                'mensaje' => $id == 0 ? 'Se ha creado el area de gastos correctamente' : 'Se ha editado el area de gastos correctamente'
            ];
        } else {
            return [
                'tipo' => 'warning',
                'mensaje' => $id == 0 ? 'No se ha podido crear el departamento' : 'No se ha podido editar el departamento'
            ];
        }
    }

    private function borrar(AreasGastosDAO $areasGastosDAO)
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
        $nombre = "Borrado$random";

        if ($areasGastosDAO->borrar($id, $nombre)) {
            return [
                'tipo' => 'success',
                'mensaje' => 'Se ha borrado el area de gastos correctamente'
            ];
        } else {
            return [
                'tipo' => 'danger',
                'mensaje' => 'Ha sucedido un problema al borrar el area de gastos'
            ];
        }
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireAdmin();
    }
}