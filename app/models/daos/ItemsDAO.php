<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Item.php';

class ItemsDAO
{
    private $db;
    public $last_insert;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id): Item
    {
        $stmt = $this->db->prepare( "SELECT 
                                            `id`, 
                                            `nombre`,
                                            `cantidad`
                                        FROM `vista_resumen_movimientos` 
                                        WHERE `id`=:id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return new Item($row['id'], $row['nombre'],$row['cantidad']);
    }

    public function comprobrarNombre($nombre, $excluirId = null)
    {
        $sql = "SELECT COUNT(id) FROM materiales WHERE nombre = :nombre";
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
        $stmt = $this->db->prepare("SELECT COUNT(id) FROM materiales WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear($nombre)
    {
        $stmt = $this->db->prepare("INSERT INTO `materiales`(`nombre`) VALUES (:nombre)");
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
        $stmt = $this->db->prepare("UPDATE materiales SET nombre = :nombre WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre
        ]);
    }

    public function listar()
    {
        $stmt = $this->db->query("SELECT 
            `id`, 
            `nombre`, 
            `cantidad` 
        FROM `vista_resumen_movimientos`
        WHERE 1
        ORDER BY `nombre` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Item($row['id'],$row['nombre'], $row['cantidad']);
        }

        return $result;
    }
}