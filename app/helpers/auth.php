<?php
function requireLogin(): bool {
    session_start();
    if (!isset($_SESSION['usuario'])) {
        return false;
    }
    return true;
}

function requireAdmin(): bool {
    session_start();
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 1) {
        return false;
    }
    return true;
}