<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Departamento.php';

class DepartamentosDAO
{
    private $db;
    public $last_insert;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id): Departamento
    {
        $stmt = $this->db->prepare( "SELECT 
                                                `id`, 
                                                `nombre` 
                                            FROM `departamentos` 
                                            WHERE `id`=:id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return new Departamento($row['id'], $row['nombre']);
    }

    public function comprobrarNombre($nombre, $excluirId = null)
    {
        $sql = "SELECT COUNT(*) FROM departamentos WHERE nombre = :nombre";
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
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM departamentos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear($nombre)
    {
        $stmt = $this->db->prepare("INSERT INTO `departamentos`(`nombre`) VALUES (:nombre)");
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
        $stmt = $this->db->prepare("UPDATE departamentos SET nombre = :nombre WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre
        ]);
    }

    public function listar()
    {
        $stmt = $this->db->query("SELECT `id`,`nombre` FROM `departamentos` WHERE 1 ORDER BY `nombre` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Departamento($row['id'],$row['nombre']);
        }

        return $result;
    }
}