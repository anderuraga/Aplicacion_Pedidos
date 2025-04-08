<?php 
require_once __DIR__.'/../helpers/auth.php';

class PedidosController extends Controller {
    public function index() {
        requireAdmin();
        $this->view("pedidos");
    }

    public function detalles() {
        requireAdmin();
        $this->view("pedidodetalles");
    }

    public function listar() {
        
    }
}