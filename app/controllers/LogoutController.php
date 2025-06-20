<?php
class LogoutController extends Controller {
    public function index() {
        session_start();

        // Destruir la sesión completamente
        $_SESSION = [];
        session_destroy();

        // Redirigir al login
        header('Location: ' . BASE_URL);
        exit;
    }
}