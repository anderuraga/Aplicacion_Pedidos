<?php 
require_once __DIR__.'/../helpers/auth.php';

class ReportesController extends Controller {
    public function index() {
        requireAdmin();
        $this->view("reportes");
    }

    public function listar() {
        
    }
}