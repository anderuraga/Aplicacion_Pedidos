<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Transaccion.php';

class TransaccionesDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function transaccionesArea($id_area)
    {
        $stmt = $this->db->prepare("
        SELECT t.*, ag.nombre AS nombre_area
        FROM transacciones t
        JOIN areas_gasto ag ON ag.id = t.id_area
        WHERE t.id_area = :id_area
        ORDER BY t.fecha DESC
                ");

        $stmt->execute(['id_area' => $id_area]);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Transaccion($row);
        }

        return $result;
    }

    public function ingresos()
    {
        $stmt = $this->db->prepare("
        SELECT 
            t.*, 
            a.nombre AS nombre_area
        FROM transacciones t
        JOIN areas_gasto a ON t.id_area = a.id
        WHERE t.cantidad > 0
        ORDER BY t.fecha DESC, t.id DESC
        ");
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Transaccion($row);
        }

        return $result;
    }

    public function crear($area, $fecha, $descr, $cantidad)
    {
        $stmt = $this->db->prepare("INSERT INTO `transacciones`(`id_area`, `fecha`, `descripcion`, `cantidad`) VALUES (:area,:fecha,:descr,:cantidad)");
        return $stmt->execute([
            'area' => $area,
            'fecha' => $fecha,
            'descr' => $descr,
            'cantidad' => $cantidad,
        ]);
    }
}