<?php
require_once __DIR__ . '/../helpers/Mailer.php';
class LoginController extends Controller
{
    public function index()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->login()) {

                header('Location: ' . BASE_URL . 'Menu');
            } else {
                $_SESSION['alert'] = [
                    'tipo' => 'danger',
                    'mensaje' => "La combinación correo contraseña no es correcta"
                ];
            }
        }

        $this->view("auth/login");
    }

    private function login()
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

    public function recuperar()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->generarCodigo()) {
                $_SESSION['alert'] = [
                    'tipo' => 'success',
                    'mensaje' => "Si ese correo electrónico está asociado a alguna cuenta, se le ha enviado un correo para recuperar la contraseña"
                ];
                session_write_close();
                header('Location: ' . BASE_URL);
            } else {
                $_SESSION['alert'] = [
                    'tipo' => 'danger',
                    'mensaje' => "Ha sucedido algún error al intentar recuperar la contraseña. Por favor, intentelo de nuevo."
                ];
            }
        }
        $this->view("auth/recuperar");
    }

    private function generarCodigo(): bool
    {
        $correo = $_POST['correo'] ?? '';
        /**
         * @var UsuariosDAO
         */
        $usuariosDAO = $this->dao("Usuarios");
        if ($usuariosDAO->comprobarCorreo($correo)) {
            $token = bin2hex(random_bytes(32));
            if ($usuariosDAO->nuevoTokenRecuperacion($correo, $token)) {
                $mailer = new Mailer();
                $mailer->enviarCorreo(
                    $correo,
                    "Recuperar Contraseña",
                    "RecuperarContrasena",
                    [
                        'enlace' => "http://" . HOST . BASE_URL . "Login/cambiar?token=$token",
                    ]
                );
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    public function cambiar()
    {
        session_start();
        /**
         * @var UsuariosDAO
         */
        $usuariosDAO = $this->dao("Usuarios");
        $info = $this->comprobarToken($usuariosDAO);

        if ($info === false) {
            $_SESSION['alert'] = [
                'tipo' => 'danger',
                'mensaje' => "El token proporcionado no es valido"
            ];
            session_write_close();
            header('Location: ' . BASE_URL);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_SESSION['alert'] = $this->cambiarContrasena($usuariosDAO);
            if($_SESSION['alert']['tipo']=='success'){
                session_write_close();
                header('Location: ' . BASE_URL);
            }
        }

        $this->view("auth/cambiar");
    }

    private function comprobarToken(UsuariosDAO $usuariosDAO)
    {
        if (!isset($_GET['token']) || strlen($_GET['token']) != 64) {
            return false;
        }

        return $usuariosDAO->comprobarToken($_GET['token']);
    }

    private function cambiarContrasena(UsuariosDAO $usuariosDAO){
        $contrasena = $_POST['contrasena'] ?? '';
        $contrasenaConfirm = $_POST['contrasenaconfirm'] ?? '';
        $token = $_GET['token'];
        
        if(strlen($contrasena)<8){
            return [
                    'tipo' => 'warning',
                    'mensaje' => "La contraseña tiene que tener más de 8 caracteres."
                ];
        }else if($contrasena!=$contrasenaConfirm){
            return [
                    'tipo' => 'warning',
                    'mensaje' => "Las contraseñas no coinciden."
                ];
        }

        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        $usuario = $usuariosDAO->comprobarToken($token);
        $ok = $usuariosDAO->cambiarContrasena($usuario['id'],$usuario['id_usuario'],$contrasenaHash);
        if($ok){
            return [
                    'tipo' => 'success',
                    'mensaje' => "Se ha actualizado la contraseña correctamente."
                ];
        }else{
            return [
                    'tipo' => 'danger',
                    'mensaje' => "Ha sucedido un error."
                ];
        }

    }
}