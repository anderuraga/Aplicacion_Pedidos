<?php 
require_once __DIR__.'/../helpers/auth.php';

class InventarioController extends Controller {
    public function index() {
        requireAdmin();
        $this->view("inventario");
    }

    public function listar() {
        
    }
}