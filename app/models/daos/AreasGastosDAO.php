<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/AreaGastos.php';

class AreasGastosDAO
{
    private $db;

    public $last_insert;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function comprobrarNombre($nombre, $excluirId = null): bool
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

    public function comprobarId($id): bool
    {
        // TODO cambiar * por id
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM areas_gastos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }


    public function listar()
    {
        $stmt = $this->db->query("SELECT 
                                    `id_area`, 
                                    `nombre_area`, 
                                    `id_departamento`, 
                                    `nombre_departamento`, 
                                    `ingresos`, 
                                    `gastos`, 
                                    `total` 
                                FROM `vista_resumen_areas` 
                                WHERE 1 
                                ORDER BY 
                                    `nombre_area` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new AreaGastos($row['id_area'], $row['nombre_area'], $row['id_departamento'], $row['nombre_departamento'],$row['ingresos'],$row['gastos'],$row['total']);
        }

        return $result;
    }

    public function obtener($id)
    {
        $stmt = $this->db->prepare( "SELECT 
                                                `id_area`, 
                                                `nombre_area`, 
                                                `id_departamento`, 
                                                `nombre_departamento`, 
                                                `ingresos`, 
                                                `gastos`, 
                                                `total` 
                                            FROM `vista_resumen_areas` 
                                            WHERE `id_area` = :id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return new AreaGastos($row['id_area'], $row['nombre_area'], $row['id_departamento'], $row['nombre_departamento'],$row['ingresos'],$row['gastos'],$row['total']);
    }

    public function crear($nombre, $id_departamento)
    {
        $stmt = $this->db->prepare("INSERT INTO areas_gastos (nombre, id_departamento) VALUES (:nombre, :id_departamento)");
        $ok = $stmt->execute([
            'nombre' => $nombre,
            'id_departamento' => $id_departamento
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }

        return false;
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