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
                                    u.`id` as usuario_id, 
                                    u.`tipo` as usuario_tipo, 
                                    u.`nombre` as usuario_nombre, 
                                    u.`correo` as usuario_correo, 
                                    u.`contrasena`, 
                                    u.`id_departamento` as departamento_id,
                                    d.nombre as departamento_nombre 
                                FROM `usuarios` u 
                                    JOIN departamentos d 
                                        ON u.id_departamento=d.id 
                                WHERE u.baja IS NULL AND u.id=:id
                                ORDER BY u.nombre ASC");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Usuario::fromArray($row);
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
                                    u.`id` as usuario_id, 
                                    u.`tipo` as usuario_tipo, 
                                    u.`nombre` as usuario_nombre, 
                                    u.`correo` as usuario_correo, 
                                    u.`contrasena`, 
                                    u.`id_departamento` as departamento_id,
                                    d.nombre as departamento_nombre 
                                FROM `usuarios` u 
                                    JOIN departamentos d 
                                        ON u.id_departamento=d.id 
                                WHERE u.baja IS NULL
                                ORDER BY u.nombre ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Usuario::fromArray($row);
        }

        return $result;
    }

    public function login($correo, $contrasena): Usuario|null
    {
        $stmt = $this->db->prepare(query: "SELECT 
                                                u.`id` as usuario_id, 
                                                u.`tipo` as usuario_tipo, 
                                                u.`nombre` as usuario_nombre, 
                                                u.`correo` as usuario_correo, 
                                                u.`contrasena`, 
                                                u.`id_departamento` as departamento_id,
                                                d.nombre as departamento_nombre 
                                            FROM `usuarios` u 
                                                JOIN departamentos d 
                                                    ON u.id_departamento=d.id 
                                            WHERE `correo`=:correo AND `baja` IS NULL");
        $stmt->execute(['correo' => $correo]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($contrasena, $row['contrasena'])) {
                return Usuario::fromArray($row);
            }
        }
        return null;
    }

    public function editar($id, $nombre, $correo, $departamento, $tipo, $contrasena)
    {
        $sql = "UPDATE `usuarios` 
                SET 
                    `nombre` = :nombre,
                    `correo` = :correo,
                    `id_departamento` = :departamento,
                    `tipo` = :tipo";

        if ($contrasena !== null) {
            $sql .= ", `contrasena` = :contrasena";
        }

        $sql .= " WHERE `id` = :id";

        $stmt = $this->db->prepare($sql);

        $params = [
            'nombre' => $nombre,
            'correo' => $correo,
            'departamento' => $departamento,
            'id' => $id,
            'tipo' => $tipo
        ];

        if ($contrasena !== null) {
            $params['contrasena'] = password_hash($contrasena, PASSWORD_DEFAULT);
        }

        return $stmt->execute($params);
    }

    public function crear($nombre, $correo, $departamento, $tipo, $contrasena)
    {
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
        // TODO: Enviar correo con la contraseña generada al usuario
        $stmt = $this->db->prepare("INSERT INTO 
                                                `usuarios`(`nombre`, `correo`, `contrasena`, `id_departamento`, `tipo`)
                                                 VALUES (:nombre,:correo,:contrasena,:id_departamento, :tipo)");
        $ok = $stmt->execute([
            'nombre' => $nombre,
            'correo' => $correo,
            'contrasena' => $contrasenaHash,
            'id_departamento' => $departamento,
            'tipo' => $tipo
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }

        return false;
    }

}