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
        $stmt = $this->db->prepare("SELECT COUNT(id) FROM areas_gastos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }


    public function listar()
    {
        $stmt = $this->db->query("SELECT 
                                    `id_area` as area_id, 
                                    `nombre_area` as area_nombre, 
                                    `id_departamento` as departamento_id, 
                                    `nombre_departamento` as departamento_nombre, 
                                    `ingresos`, 
                                    `gastos`,
                                    `gasto_pendiente`,
                                    `total` as diferencia
                                FROM `vista_resumen_areas` 
                                WHERE 1 
                                ORDER BY 
                                    `nombre_area` ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = AreaGastos::fromArray($row);
        }

        return $result;
    }

    public function obtener($id)
    {
        $stmt = $this->db->prepare("SELECT 
                                            `id_area` as area_id, 
                                            `nombre_area` as area_nombre, 
                                            `id_departamento` as departamento_id, 
                                            `nombre_departamento` as departamento_nombre, 
                                            `ingresos`, 
                                            `gastos`,
                                            `gasto_pendiente`,
                                            `total` as diferencia
                                        FROM `vista_resumen_areas`
                                        WHERE `id_area` = :id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return AreaGastos::fromArray($row);
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

    public function reportes($anio)
    {
        $sql = "SELECT
    ag.id               AS id_area,
    ag.nombre           AS nombre_area,
    ag.id_departamento  AS id_departamento,
    d.nombre            AS nombre_departamento,
    IFNULL(
      SUM(
        CASE WHEN t.cantidad > 0 THEN t.cantidad ELSE 0 END
      ),
    0) AS ingresos,
    IFNULL(
      SUM(
        CASE WHEN t.cantidad < 0 THEN ABS(t.cantidad) ELSE 0 END
      ),
    0) AS gastos,
    IFNULL(
      (
        SELECT SUM(p.importe)
        FROM elorrieta.pedidos p
        WHERE p.id_area_gasto   = ag.id
          AND p.id_estado       BETWEEN 0 AND 5
          AND p.anio_contable   = :anio
      ),
    0) AS gasto_pendiente,
    IFNULL(
      SUM(
        CASE WHEN t.cantidad > 0 THEN t.cantidad ELSE 0 END
      ),
    0)
    - (
        IFNULL(
          SUM(
            CASE WHEN t.cantidad < 0 THEN ABS(t.cantidad) ELSE 0 END
          ),
        0)
        + IFNULL(
            (
              SELECT SUM(p.importe)
              FROM elorrieta.pedidos p
              WHERE p.id_area_gasto   = ag.id
                AND p.id_estado       BETWEEN 0 AND 5
                AND p.anio_contable   = :anio
            ),
          0
        )
      ) AS total
FROM elorrieta.areas_gastos ag
LEFT JOIN elorrieta.departamentos d
  ON ag.id_departamento = d.id
LEFT JOIN elorrieta.transacciones t
  ON ag.id     = t.id_area
  AND YEAR(t.fecha) = :anio
GROUP BY
    ag.id,
    ag.nombre,
    ag.id_departamento,
    d.nombre;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'anio' => $anio
        ]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $gastos = (float)$row['gastos'];
            $gastospendiente = (float)$row['gasto_pendiente'];
            $gastos_total = $gastos + $gastospendiente; 
            $row['gastos'] = getCantidadFormateada((float)$row['gastos']);
            $row['gasto_pendiente'] = getCantidadFormateada((float)$row['gasto_pendiente']);
            $row['total'] = getCantidadFormateada((float)$row['total']);
            
            $row['total_gastos'] = getCantidadFormateada($gastos_total);
            $result[] = $row;
        }
        return $result;
    }
}
