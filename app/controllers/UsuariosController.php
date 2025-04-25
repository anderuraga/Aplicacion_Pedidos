<?php 
require_once __DIR__.'/../helpers/auth.php';

class UsuariosController extends Controller {
    public function index() {
        $usuariosDAO = $this->dao("Usuarios");
        $usuarios = $usuariosDAO->listar();
        
        $this->view("usuarios/index",['usuarios' => $usuarios]);
    }

    #[\Override]
    public function tiene_permiso(): bool {
        return requireAdmin();
    }
}