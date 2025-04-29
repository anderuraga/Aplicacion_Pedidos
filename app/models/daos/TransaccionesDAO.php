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
                                                t.`id`,
                                                t.`id_area`, 
                                                t.`fecha`, 
                                                t.`descripcion`, 
                                                t.`cantidad`, 
                                                ag.nombre as area_nombre 
                                            FROM `transacciones` t 
                                                JOIN areas_gastos ag 
                                                    ON t.id_area=ag.id 
                                            WHERE t.id_area=:id_area
                                            ORDER BY t.fecha DESC");

        $stmt->execute(['id_area' => $id_area]);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Transaccion(
                $row['id'],
                $row['id_area'],
                $row['area_nombre'],
                $row['fecha'],
                $row['descripcion'],
                $row['cantidad']
            );
        }

        return $result;
    }

    public function ingresos()
    {
        $stmt = $this->db->prepare(query: "SELECT 
                                                t.`id`,
                                                t.`id_area`, 
                                                t.`fecha`, 
                                                t.`descripcion`, 
                                                t.`cantidad`, 
                                                ag.nombre as area_nombre 
                                            FROM `transacciones` t 
                                                JOIN areas_gastos ag 
                                                    ON t.id_area=ag.id
                                            WHERE t.cantidad > 0
                                            ORDER BY t.fecha DESC, t.id DESC
                                            ");
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Transaccion(
                $row['id'],
                $row['id_area'],
                $row['area_nombre'],
                $row['fecha'],
                $row['descripcion'],
                $row['cantidad']
            );
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
            'cantidad' => $cantidad,
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
                                                t.`id`,
                                                t.`id_area`, 
                                                t.`fecha`, 
                                                t.`descripcion`, 
                                                t.`cantidad`, 
                                                ag.nombre as area_nombre 
                                            FROM `transacciones` t 
                                                JOIN areas_gastos ag 
                                                    ON t.id_area=ag.id
                                            WHERE t.`id`=:id
                                            ORDER BY t.fecha DESC, t.id DESC
                                            ");
        $stmt->execute([
            'id' => $id
        ]);
        $row = $stmt->fetch();
        return new Transaccion(
            $row['id'],
            $row['id_area'],
            $row['area_nombre'],
            $row['fecha'],
            $row['descripcion'],
            $row['cantidad']
        );

    }
}