<?php 
require_once __DIR__.'/../helpers/auth.php';

class ProveedoresController extends Controller {
    public function index() {
        requireAdmin();
        $this->view("proveedores");
    }

    public function listar() {
        
    }
}