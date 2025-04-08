<?php 
require_once __DIR__.'/../helpers/auth.php';

class UsuariosController extends Controller {
    public function index() {
        requireAdmin();
        $this->view("usuarios");
    }

    public function listar() {
        
    }
}