<?php 
require_once __DIR__.'/../helpers/auth.php';

class MenuController extends Controller {
    
    public function index() {
        $this->view("menu");
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }
}