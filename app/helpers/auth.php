<?php
require_once __DIR__ . "\\..\\models\\vo\\Usuario.php";
function requireLogin(): bool
{
    return conseguirUsuario();
}

function conseguirUsuario(): bool
{
    /**
     * @global Usuario $usuario
     */
    global $usuario;
    session_start();
    if (isset($_SESSION['usuario'])) {
        $usuario = unserialize($_SESSION['usuario']);
        return true;
    }
    return false;

}

function requireAdmin(): bool
{
    global $usuario;
    if (conseguirUsuario()) {
        if ($usuario->tipo==1) {
            return true;
        }
    }
    return false;
}