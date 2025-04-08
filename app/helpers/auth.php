<?php
function requireLogin() {
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: /");
        exit;
    }
}

function requireAdmin() {
    session_start();
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 1) {
        header("Location: /");
        exit;
    }
}