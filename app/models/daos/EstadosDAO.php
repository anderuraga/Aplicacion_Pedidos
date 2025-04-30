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
                                                `id`, 
                                                `nombre` 
                                            FROM `estado` 
                                            WHERE `id`=:id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return new Estado($row['id'], $row['nombre']);
    }

    public function comprobrarNombre($nombre, $excluirId = null)
    {
         // TODO cambiar * por un id
        $sql = "SELECT COUNT(*) FROM estado WHERE nombre = :nombre";
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
         // TODO cambiar * por un id
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM estado WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function editar($id, $nombre)
    {
        $stmt = $this->db->prepare("UPDATE estado SET nombre = :nombre WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre
        ]);
    }

    public function listar()
    {
        $stmt = $this->db->query("SELECT `id`,`nombre` FROM `estado` WHERE 1 ORDER BY `id` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Estado($row['id'],$row['nombre']);
        }

        return $result;
    }
}