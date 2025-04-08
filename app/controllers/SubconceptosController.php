<?php 
require_once __DIR__.'/../helpers/auth.php';

class SubconceptosController extends Controller {
    public function index() {
        requireAdmin();
        $this->view("subconceptos");
    }

    public function listar() {
        
    }
}