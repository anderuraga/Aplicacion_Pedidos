<?php 
require_once __DIR__.'/../helpers/auth.php';

class EstadosController extends Controller {
    public function index() {
        requireAdmin();
        $this->view("estados");
    }

    public function listar() {
        
    }
}