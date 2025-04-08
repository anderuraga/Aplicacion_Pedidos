<?php
class LoginController extends Controller
{
    public function index()
    {
        $this->view("login");
    }

    public function autenticar()
    {
        header('Content-Type: application/json');

        $usuario = $_POST['correo'] ?? '';
        $clave = $_POST['contrasena'] ?? '';

        $usuarioModel = $this->model("Usuario");
        $usuarioValido = $usuarioModel->verificar($usuario, $clave);

        if ($usuarioValido) {
            session_start();
            $_SESSION['usuario'] = [
                'id' => $usuarioValido['id'],
                'tipo' => $usuarioValido['tipo'],
                'nombre' => $usuarioValido['nombre'],
                'id_departamento' => $usuarioValido['id_departamento'],
                'nombre_departamento' => $usuarioValido['nombre_departamento']
            ];

            echo json_encode([
                'success' => true,
                'message' => 'Login exitoso'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ]);
        }
    }
}