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
        $stmt = $this->db->prepare("SELECT
    v.`id` AS item_id,
    v.departamento_id AS departamento_id,
    d.nombre AS departamento_nombre,
    v.`nombre` AS item_nombre,
    v.`cantidad` AS item_cantidad
FROM
    `vista_resumen_movimientos` v
JOIN
	departamentos d ON d.id=v.departamento_id
WHERE
    v.`id` = :id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Item::fromArray($row);
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

    public function crear($nombre, $departamento)
    {
        $stmt = $this->db->prepare("INSERT INTO `materiales`(`id_departamento`, `nombre`) VALUES (:departamento,:nombre)");
        $ok = $stmt->execute([
            'departamento' => $departamento,
            'nombre' => $nombre
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }

        return false;
    }

    public function editar($id, $nombre, $departamento)
    {
        $stmt = $this->db->prepare("UPDATE materiales SET nombre = :nombre, `id_departamento`=:departamento WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'departamento' => $departamento
        ]);
    }

    public function listar()
    {
        $stmt = $this->db->query("SELECT
    v.`id` AS item_id,
    v.departamento_id,
    d.nombre as departamento_nombre,
    v.`nombre` AS item_nombre,
    v.`cantidad` AS item_cantidad
FROM
    `vista_resumen_movimientos` v
JOIN
	departamentos d ON d.id=v.departamento_id
WHERE 1
        ORDER BY v.`nombre` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Item::fromArray($row);
        }

        return $result;
    }

    public function listar_departamento($departamento)
    {
        $stmt = $this->db->prepare("SELECT
    v.`id` AS item_id,
    v.departamento_id,
    d.nombre AS departamento_nombre,
    v.`nombre` AS item_nombre,
    v.`cantidad` AS item_cantidad
FROM
    `vista_resumen_movimientos` v
JOIN departamentos d ON
    d.id = v.departamento_id
WHERE
    `departamento_id` = :departamento
ORDER BY
    v.`nombre` ASC");
        $stmt->execute([
            "departamento" => $departamento
        ]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Item::fromArray($row);
        }

        return $result;
    }
}