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

    public function listar()
    {
        $stmt = $this->db->query("SELECT 
                                    u.`id`, 
                                    u.`tipo`, 
                                    u.`nombre`, 
                                    u.`correo`, 
                                    u.`contrasena`, 
                                    u.`id_departamento`,
                                    d.nombre as departamento_nombre 
                                FROM `usuarios` u 
                                    JOIN departamentos d 
                                        ON u.id_departamento=d.id 
                                WHERE u.baja IS NULL 
                                ORDER BY u.nombre ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Usuario(
                id: $row['id'],
                tipo: $row['tipo'],
                nombre: $row['nombre'],
                correo: $row['correo'],
                departamento_id: $row['id_departamento'],
                departamento_nombre: $row['departamento_nombre']
            );
        }

        return $result;
    }

    public function login($correo, $contrasena): Usuario|null
    {
        $stmt = $this->db->prepare( query: "SELECT 
                                                u.`id`, 
                                                u.`tipo`, 
                                                u.`nombre`, 
                                                u.`correo`, 
                                                u.`contrasena`, 
                                                u.`id_departamento`,
                                                d.nombre as departamento_nombre 
                                            FROM `usuarios` u 
                                                JOIN departamentos d 
                                                    ON u.id_departamento=d.id 
                                            WHERE `correo`=:correo AND `baja` IS NULL");
        $stmt->execute(['correo' => $correo]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($contrasena, $row['contrasena'])) {
                return new Usuario(
                    id: $row['id'],
                    tipo: $row['tipo'],
                    nombre: $row['nombre'],
                    correo: $row['correo'],
                    departamento_id: $row['id_departamento'],
                    departamento_nombre: $row['departamento_nombre']
                );
            }
        }
        return null;
    }

}