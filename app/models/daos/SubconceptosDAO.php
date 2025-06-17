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
                                                `nombre` as subconcepto_nombre
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

    public function crear( $idnuevo, $nombre)
    {
        $stmt = $this->db->prepare("INSERT INTO `subconceptos`(`id`,`nombre`) VALUES (:idnuevo, :nombre)");
        $ok = $stmt->execute([
            'idnuevo' => $idnuevo,
            'nombre' => $nombre
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }

        return false;
    }

    public function editar($id, $idnuevo, $nombre)
    {
        $stmt = $this->db->prepare(query: "UPDATE `subconceptos` 
                                            SET 
                                                `nombre`= :nombre, 
                                                `id` = :idnuevo
                                            WHERE 
                                                `id`=:id");
        return $stmt->execute([
            'id' => $id,
            'idnuevo' => $idnuevo,
            'nombre' => $nombre
        ]);
    }

    public function listar()
    {
        $stmt = $this->db->query("SELECT 
                                            `id` as subconcepto_id, 
                                            `nombre` as subconcepto_nombre
                                        FROM `subconceptos` 
                                        WHERE baja IS NULL
                                        ORDER BY `nombre` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Subconcepto::fromArray($row);
        }

        return $result;
    }

    public function borrar($id, $nombre)
    {
        $sql = "UPDATE
                    `subconceptos`
                SET
                    `nombre` = :nombre,
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