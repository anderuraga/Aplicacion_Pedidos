<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/TipoServicio.php';

class TiposServicioDAO
{
    private $db;
    public $last_insert;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id): TipoServicio
    {
        $stmt = $this->db->prepare("SELECT 
                                        `id` as tiposervicio_id, 
                                        `nombre` as tiposervicio_nombre
                                    FROM `tipos_servicio`
                                    WHERE `id`=:id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return TipoServicio::fromArray($row);
    }

    public function comprobrarNombre($nombre, $excluirId = null)
    {
        $sql = "SELECT COUNT(*) FROM tipos_servicio WHERE nombre = :nombre";
        if ($excluirId !== null) {
            $sql .= " AND id != :id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nombre', $nombre);
        if ($excluirId !== null) {
            $stmt->bindValue(':id', $excluirId);
        }
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function comprobarId($id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tipos_servicio WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear($nombre)
    {
        $stmt = $this->db->prepare("INSERT INTO `tipos_servicio`(`nombre`) VALUES (:nombre)");
        $ok = $stmt->execute([
            'nombre' => $nombre
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }

        return false;
    }

    public function editar($id, $nombre)
    {
        $stmt = $this->db->prepare("UPDATE tipos_servicio SET nombre = :nombre WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre
        ]);
    }

    public function listar()
    {
        $stmt = $this->db->query("SELECT
                                            `id` as tiposervicio_id,
                                            `nombre` as tiposervicio_nombre
                                        FROM
                                            `tipos_servicio`
                                        WHERE
                                            baja IS NULL
                                        ORDER BY
                                            `nombre` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = TipoServicio::fromArray($row);
        }

        return $result;
    }

    public function borrar($id, $nombre)
    {
        $sql = "UPDATE
    `tipos_servicio`
SET
    `nombre` = :nombre ,
    `baja` = NOW()
WHERE
    `id` = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre
        ]);
    }
}