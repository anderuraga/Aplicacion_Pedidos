<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Usuario.php';

class UsuariosDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function login($correo, $contrasena): Usuario|null{
        $stmt = $this->db->prepare("SELECT `id`, `tipo`, `nombre`, `correo`, `contrasena`, `id_departamento`, `baja` FROM `usuarios` WHERE `correo`=:correo AND `baja` IS NULL");
        $stmt->execute(['correo' => $correo]);
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            if (password_verify($contrasena, $row['contrasena'])) {
                return new Usuario($row['id'],$row['tipo'],$row['nombre'],$row['correo'],$row['id_departamento']);
            }
        }
        return null;
    }

}