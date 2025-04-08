<?php 
require_once __DIR__.'/../helpers/auth.php';

class TiposServicioController extends Controller {
    public function index() {
        requireAdmin();
        $this->view("tiposservicio");
    }

    public function listar() {
        
    }
}