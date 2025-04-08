<?php
require_once __DIR__ . '/../../core/Database.php';

class AreaGastos
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function comprobrarNombre($nombre, $excluirId = null)
    {
        $sql = "SELECT COUNT(*) FROM areas_gastos WHERE nombre = :nombre";
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
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM areas_gastos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }


    public function listar()
    {
        $stmt = $this->db->query("SELECT ag.`id`, ag.`id_departamento`, ag.`nombre`, d.nombre as 'nombre_depart',FORMAT((SELECT SUM(t.cantidad) FROM transacciones t WHERE t.id_area=ag.id AND t.cantidad>0),2,'de_DE') as ingresos, IFNULL(FORMAT((SELECT SUM(t.cantidad) FROM transacciones t WHERE t.id_area=ag.id AND t.cantidad<0),2,'de_DE'),0) as gastos FROM `areas_gastos` ag JOIN departamentos d ON d.id=ag.id_departamento WHERE 1;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $stmt = $this->db->prepare("SELECT * FROM areas_gastos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $id_departamento)
    {
        $stmt = $this->db->prepare("INSERT INTO areas_gastos (nombre, id_departamento) VALUES (:nombre, :id_departamento)");
        return $stmt->execute([
            'nombre' => $nombre,
            'id_departamento' => $id_departamento
        ]);
    }

    public function editar($id, $nombre, $id_departamento)
    {
        $stmt = $this->db->prepare("UPDATE `areas_gastos` SET `id_departamento`=:departamento,`nombre`=:nombre WHERE `id` = :id");
        return $stmt->execute([
            'nombre' => $nombre,
            'departamento' => $id_departamento,
            'id' => $id
        ]);
    }
}