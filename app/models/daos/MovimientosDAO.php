<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Movimiento.php';

class MovimientosDAO
{
    private $db;
    public $last_insert;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id): Movimiento
    {
        $stmt = $this->db->prepare("SELECT
    m.`id` AS movimiento_id,
    m.`id_item` AS item_id,
    ma.nombre AS item_nombre,
    d.id AS departamento_id,
    d.nombre AS departamento_nombre,
    m.`fecha` AS movimiento_fecha,
    m.`descripcion` AS movimiento_descripcion,
    m.`cantidad` AS movimiento_cantidad,
    SUM(m.cantidad) OVER(
    PARTITION BY m.id_item
ORDER BY
    m.fecha,
    m.id ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
) AS movimiento_total
FROM
    `movimientos` m
JOIN materiales ma ON
    m.id_item = ma.id
JOIN departamentos d ON
    d.id = ma.id_departamento
WHERE
    m.id = :id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Movimiento::fromArray($row);
    }

    public function comprobarId($id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(id) FROM materiales WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear(array $data): bool
    {
        $sql = "INSERT INTO `movimientos`(
                    `id_item`,
                    `fecha`,
                    `descripcion`,
                    `cantidad`
                )
                VALUES(
                    :item_id,
                    :fecha,
                    :descripcion,
                    :cantidad
                )";
        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute($data);
        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
        }
        return $ok;
    }

    public function editar($id, $data)
    {
        $sql = "UPDATE
                    `movimientos`
                SET
                    `id_item` = :item_id,
                    `fecha` = :fecha,
                    `descripcion` = :descripcion,
                    `cantidad` = :cantidad
                WHERE
                    `id`=:id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function listar($id_item)
    {
        $stmt = $this->db->prepare("SELECT
    m.`id` AS movimiento_id,
    m.`id_item` AS item_id,
    ma.nombre AS item_nombre,
    d.id AS departamento_id,
    d.nombre AS departamento_nombre,
    m.`fecha` AS movimiento_fecha,
    m.`descripcion` AS movimiento_descripcion,
    m.`cantidad` AS movimiento_cantidad,
    SUM(m.cantidad) OVER(
    PARTITION BY m.id_item
ORDER BY
    m.fecha,
    m.id ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
) AS movimiento_total
FROM
    `movimientos` m
JOIN materiales ma ON
    m.id_item = ma.id
JOIN departamentos d ON
    d.id = ma.id_departamento
WHERE
    m.id_item=:id_item
ORDER BY
    m.fecha DESC, 
    m.id DESC
    ");

        $stmt->execute(['id_item' => $id_item]);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Movimiento::fromArray($row);
        }

        return $result;
    }
}