<?php
class LoginController extends Controller
{
    public function index()
    {
        $alert = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($usuario = $this->login()) {
                header('Location: Menu');
            } else {
                $_SESSION['alert'] = [
                    'tipo' => 'danger',
                    'mensaje' => "La combinación correo contraseña no es correcta"
                ];
            }
        }

        $this->view("auth/login");
    }

    public function login()
    {
        $correo = $_POST['correo'] ?? '';
        $clave = $_POST['contrasena'] ?? '';

        $UsuariosDAO = $this->dao("Usuarios");
        $usuario = $UsuariosDAO->login($correo, $clave);

        if ($usuario) {
            session_start();
            $_SESSION['usuario'] = serialize($usuario);
            return true;
        } else {
            return false;
        }
    }
}