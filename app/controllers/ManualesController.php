<?php
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/formatos.php';

class ManualesController extends Controller
{
    public function index()
    {
        global $usuario;
        $this->view("manuales/index", []);
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireLogin();
    }
}