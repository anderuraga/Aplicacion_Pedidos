<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Usuario.php';

class UsuariosDAO
{
    private $db;
    public $last_insert;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id)
    {
        $stmt = $this->db->prepare("SELECT 
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
                                WHERE u.baja IS NULL AND u.id=:id
                                ORDER BY u.nombre ASC");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return new Usuario(
            id: $row['id'],
            tipo: $row['tipo'],
            nombre: $row['nombre'],
            correo: $row['correo'],
            departamento_id: $row['id_departamento'],
            departamento_nombre: $row['departamento_nombre']
        );
    }

    public function comprobarCorreo($correo, $excluirId = 0)
    {
        $stmt = $this->db->prepare("SELECT 
                                    COUNT(`id`)
                                FROM `usuarios`
                                WHERE 
                                    `baja` IS NULL AND 
                                    `correo`=:correo AND 
                                    `id` != :id");
        $stmt->execute(['correo' => $correo, 'id' => $excluirId]);
        return $stmt->fetchColumn() > 0;
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
        $stmt = $this->db->prepare(query: "SELECT 
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

    public function editar($id, $nombre, $correo, $departamento)
    {
        $stmt = $this->db->prepare("UPDATE `usuarios` 
                                        SET 
                                            `nombre`=:nombre,
                                            `correo`=:correo,
                                            `id_departamento`=:departamento 
                                        WHERE `id`=:id");
        return $stmt->execute([
            'nombre' => $nombre,
            'correo' => $correo,
            'departamento' => $departamento,
            'id' => $id
        ]);
    }

    public function crear($nombre, $correo, $departamento)
    {
        $contrasena = $this->generarContrasena();
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
        // TODO: Enviar correo con la contraseña generada al usuario
        $stmt = $this->db->prepare("INSERT INTO 
                                                `usuarios`(`nombre`, `correo`, `contrasena`, `id_departamento`)
                                                 VALUES (:nombre,:correo,:contrasena,:id_departamento)");
        $ok = $stmt->execute([
            'nombre' => $nombre,
            'correo' => $correo,
            'contrasena' => $contrasenaHash,
            'id_departamento' => $departamento,
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }

        return false;
    }

    private function generarContrasena($length = 10): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-,.?';
        $charsLen = strlen($chars);
        $contrasena = '';

        for ($i = 0; $i < $length; $i++) {
            $contrasena .= $chars[rand(0, $charsLen - 1)];
        }

        return $contrasena;
    }

}