<?php
require_once __DIR__ . '/../../../core/Database.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Verifica si el usuario y clave existen
    public function verificar($usuario, $clave)
    {
        $stmt = $this->db->prepare("SELECT u.id, u.tipo, u.nombre, u.id_departamento, d.nombre AS nombre_departamento, u.contrasena
        FROM usuarios u
        JOIN departamentos d ON u.id_departamento = d.id
        WHERE u.correo = :correo
          AND u.baja IS NULL
        LIMIT 1
    ");
        $stmt->execute(['correo' => $usuario]);
        $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioEncontrado && password_verify($clave, $usuarioEncontrado['contrasena'])) {
            unset($usuarioEncontrado['contrasena']);
            return $usuarioEncontrado; // Login válido
        }

        return false; // Usuario no encontrado o clave incorrecta
    }
}
