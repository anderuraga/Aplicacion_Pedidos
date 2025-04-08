<?php
require_once __DIR__ . '/../helpers/auth.php';

class DepartamentosController extends Controller
{



    public function index()
    {
        requireAdmin();
        $this->view("departamentos");
    }

    public function listar()
    {
        requireAdmin();

        header('Content-Type: application/json');
        $modeloDepartamento = $this->model("Departamento");
        $departamentos = $modeloDepartamento->listar();


        echo json_encode([
            'success' => true,
            'data' => $departamentos
        ]);
    }


    public function crear()
    {
        requireAdmin();

        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'El nombre del departamento no puede estar vacío.'
            ]);
            return;
        }

        $modelo = $this->model("Departamento");

        if ($modelo->comprobrarNombre($nombre)) {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'El nombre del departamento ya existe.'
            ]);
            return;
        }

        $ok = $modelo->crear($nombre);

        echo json_encode([
            'resultado' => $ok,
            'mensaje' => $ok ? 'Departamento creado con éxito.' : 'Error al crear departamento.'
        ]);

    }

    public function editar()
    {
        requireAdmin();

        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);

        if ($nombre === '') {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'El nombre del departamento no puede estar vacío.'
            ]);
            return;
        }

        $modelo = $this->model("Departamento");

        if ($modelo->comprobrarNombre($nombre, $id)) {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'El nombre del departamento ya existe.'
            ]);
            return;
        }

        $ok = $modelo->editar($id, $nombre);

        echo json_encode([
            'resultado' => $ok,
            'mensaje' => $ok ? 'Departamento editado con éxito.' : 'Error al editar departamento.'
        ]);

    }
}