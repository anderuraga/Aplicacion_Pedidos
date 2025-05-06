<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Subconcepto.php';

class SubconceptosDAO
{
    private $db;
    public $last_insert;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id): Subconcepto
    {
        $stmt = $this->db->prepare("SELECT 
                                                `id` as subconcepto_id, 
                                                `nombre` as subconcepto_nombre, 
                                                `tipo` as subconcepto_tipo
                                            FROM `subconceptos` 
                                            WHERE `id`=:id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Subconcepto::fromArray($row);
    }

    public function comprobrarNombre($nombre, $excluirId = null)
    {
        $sql = "SELECT COUNT(*) FROM subconceptos WHERE nombre = :nombre";
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
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM subconceptos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear($nombre, $tipo)
    {
        $stmt = $this->db->prepare("INSERT INTO `subconceptos`(`nombre`, `tipo`) VALUES (:nombre, :tipo)");
        $ok = $stmt->execute([
            'nombre' => $nombre,
            'tipo' => $tipo
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }

        return false;
    }

    public function editar($id, $nombre, $tipo)
    {
        $stmt = $this->db->prepare(query:  "UPDATE `subconceptos` 
                                            SET 
                                                `nombre`= :nombre, 
                                                `tipo`= :tipo 
                                            WHERE 
                                                `id`=:id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'tipo' => $tipo
        ]);
    }

    public function listar()
    {
        $stmt = $this->db->query("SELECT 
                                            `id` as subconcepto_id, 
                                            `nombre` as subconcepto_nombre, 
                                            `tipo` as subconcepto_tipo
                                        FROM `subconceptos` 
                                        WHERE 1 
                                        ORDER BY `nombre` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Subconcepto::fromArray($row);
        }

        return $result;
    }
}