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
        $stmt = $this->db->prepare("SELECT 
                                                `id` as departamento_id, 
                                                `nombre` as departamento_nombre
                                            FROM `departamentos` 
                                            WHERE `id`=:id AND baja IS NULL");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Departamento::fromArray($row);
    }

    public function comprobrarNombre($nombre, $excluirId = null)
    {
        $sql = "SELECT COUNT(id) FROM departamentos WHERE nombre = :nombre";
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
        $stmt = $this->db->prepare("SELECT COUNT(id) FROM departamentos WHERE id = :id");
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
        $stmt = $this->db->query("SELECT
    `id` as departamento_id, 
    `nombre` as departamento_nombre
FROM
    `departamentos`
WHERE
    baja IS NULL
ORDER BY
    `nombre` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Departamento::fromArray($row);
        }

        return $result;
    }

    public function borrar($id, $nombre){
        $sql = "UPDATE
                    `departamentos`
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