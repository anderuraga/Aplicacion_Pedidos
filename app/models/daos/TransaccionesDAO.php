<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Transaccion.php';

class TransaccionesDAO
{
    private $db;
    public $last_insert;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function transaccionesArea($id_area)
    {
        $stmt = $this->db->prepare(query: "SELECT
                                                t.`id` AS transaccion_id,
                                                t.`id_area` AS area_id,
                                                ag.nombre_area AS area_nombre,
                                                ag.id_departamento AS departamento_id,
                                                ag.nombre_departamento AS departamento_nombre,
                                                ag.ingresos,
                                                ag.gastos,
                                                ag.gasto_pendiente,
                                                ag.total as diferencia,
                                                t.`fecha` AS transaccion_fecha,
                                                t.`descripcion` AS transaccion_descripcion,
                                                t.`cantidad` AS transaccion_cantidad,
                                                SUM(t.`cantidad`) 
                                                OVER (
                                                    PARTITION BY t.`id_area`
                                                    ORDER BY t.`fecha`, t.`id`
                                                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                                                ) AS transaccion_total
                                            FROM
                                                `transacciones` t
                                            JOIN vista_resumen_areas ag ON
                                                t.id_area = ag.id_area
                                            WHERE
                                                t.id_area = :id_area AND baja IS NULL
                                            ORDER BY
                                                t.fecha
                                            DESC
                                                ");

        $stmt->execute(['id_area' => $id_area]);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Transaccion::fromArray($row);
        }

        return $result;
    }

    public function ingresos()
    {
        $stmt = $this->db->prepare(query: "SELECT
                                                t.`id` AS transaccion_id,
                                                t.`id_area` AS area_id,
                                                ag.nombre_area AS area_nombre,
                                                ag.id_departamento AS departamento_id,
                                                ag.nombre_departamento AS departamento_nombre,
                                                ag.ingresos,
                                                ag.gastos,
                                                ag.gasto_pendiente,
                                                ag.total as diferencia,
                                                t.`fecha` AS transaccion_fecha,
                                                t.`descripcion` AS transaccion_descripcion,
                                                t.`cantidad` AS transaccion_cantidad,
                                                SUM(t.`cantidad`) 
                                                OVER (
                                                    PARTITION BY t.`id_area`
                                                    ORDER BY t.`fecha`, t.`id`
                                                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                                                ) AS transaccion_total
                                            FROM
                                                `transacciones` t
                                            JOIN vista_resumen_areas ag ON
                                                t.id_area = ag.id_area
                                            WHERE
                                                t.cantidad > 0 AND baja IS NULL
                                            ORDER BY
                                                t.fecha
                                            DESC
                                                ,
                                                t.id
                                            DESC
                                            ");
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Transaccion::fromArray($row);
        }

        return $result;
    }

    public function crear($fecha, $descr, $area, $cantidad): bool
    {
        $stmt = $this->db->prepare("INSERT INTO `transacciones`(`id_area`, `fecha`, `descripcion`, `cantidad`) VALUES (:area,:fecha,:descr,:cantidad)");
        $ok = $stmt->execute([
            'area' => $area,
            'fecha' => $fecha,
            'descr' => $descr,
            'cantidad' => $cantidad
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }

        return false;
    }

    public function editar($id, $fecha, $descr, $area, $cantidad)
    {
        $stmt = $this->db->prepare("UPDATE `transacciones` SET `id_area`= :area,`fecha`= :fecha,`descripcion`=:descr,`cantidad`=:cantidad WHERE `id`=:id");
        return $stmt->execute([
            'area' => $area,
            'fecha' => $fecha,
            'descr' => $descr,
            'cantidad' => $cantidad,
            'id' => $id
        ]);
    }

    public function obtener($id)
    {
        $stmt = $this->db->prepare(query: "SELECT
                                                t.`id` AS transaccion_id,
                                                t.`id_area` AS area_id,
                                                ag.nombre_area AS area_nombre,
                                                ag.id_departamento AS departamento_id,
                                                ag.nombre_departamento AS departamento_nombre,
                                                ag.ingresos,
                                                ag.gastos,
                                                ag.gasto_pendiente,
                                                ag.total as diferencia,
                                                t.`fecha` AS transaccion_fecha,
                                                t.`descripcion` AS transaccion_descripcion,
                                                t.`cantidad` AS transaccion_cantidad,
                                                SUM(t.`cantidad`) 
                                                OVER (
                                                    PARTITION BY t.`id_area`
                                                    ORDER BY t.`fecha`, t.`id`
                                                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                                                ) AS transaccion_total
                                            FROM
                                                `transacciones` t
                                            JOIN vista_resumen_areas ag ON
                                                t.id_area = ag.id_area
                                            WHERE
                                                t.`id` = :id
                                            ORDER BY
                                                t.fecha DESC,
                                                t.id DESC
                                            ");
        $stmt->execute([
            'id' => $id
        ]);
        $row = $stmt->fetch();
        return Transaccion::fromArray($row);

    }

    public function borrar($id,$descripcion)
    {
        $sql = "UPDATE
                    `transacciones`
                SET
                    `descripcion` = :descripcion,
                    `cantidad` = 0,
                    `baja` = NOW()
                WHERE
                    `id` = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'descripcion' => $descripcion
        ]);
    }
}