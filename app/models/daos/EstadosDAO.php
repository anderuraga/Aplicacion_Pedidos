<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Estado.php';

class EstadosDAO
{
    private $db;
    public $last_insert;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id): Estado
    {
        $stmt = $this->db->prepare( "SELECT 
                                                `id` as estado_id,
                                                `nombre` as estado_nombre,
                                                `icono`
                                            FROM `estado` 
                                            WHERE `id`=:id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Estado::fromArray($row);
    }

    public function comprobrarNombre($nombre, $excluirId = null)
    {
        $sql = "SELECT COUNT(id) FROM estado WHERE nombre = :nombre";
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
        $stmt = $this->db->prepare("SELECT COUNT(id) FROM estado WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function editar($id, $nombre, $icono)
    {
        $stmt = $this->db->prepare("UPDATE estado SET nombre = :nombre, icono = :icono WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'icono' => $icono
        ]);
    }

    public function listar()
    {
        $stmt = $this->db->query("SELECT
    `id` as estado_id,
    `nombre` as estado_nombre,
    `icono`
FROM
    `estado`
WHERE
    1
ORDER BY
    `id` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Estado::fromArray($row);
        }

        return $result;
    }
}