<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Incidencia.php';

class IncidenciasDAO
{
    private $db;
    public $last_insert;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function listar_estado($id_pedido, $estado)
    {
        $stmt = $this->db->prepare("SELECT
                                        `id` as incidencia_id,
                                        `fecha` as incidencia_fecha,
                                        `descripcion` as incidencia_descripcion,
                                        `estado` as incidencia_estado,
                                        `fecha_solucionada` as incidencia_fecha_solucion
                                    FROM
                                        `incidencias`
                                    WHERE
                                        `id_pedido` = :id_pedido AND `estado` = :estado
                                    ORDER BY
                                        `fecha`
                                    DESC");
        $stmt->execute([
            'id_pedido' => $id_pedido,
            'estado' => $estado
        ]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Incidencia::fromArray($row);
        }
        return $result;
    }

    public function obtener($id): Incidencia
    {
        $stmt = $this->db->prepare("SELECT
                                        `id` as incidencia_id,
                                        `fecha` as incidencia_fecha,
                                        `descripcion` as incidencia_descripcion,
                                        `estado` as incidencia_estado,
                                        `fecha_solucionada` as incidencia_fecha_solucion
                                    FROM
                                        `incidencias`
                                    WHERE
                                        `id`=:id");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Incidencia::fromArray($row);
    }

    public function crear($id_pedido, $descripcion)
    {
        $stmt = $this->db->prepare("INSERT INTO `incidencias`(`id_pedido`, `descripcion`)
                                            VALUES(:id_pedido, :descripcion)");
        $ok = $stmt->execute([
            'id_pedido' => $id_pedido,
            'descripcion' => $descripcion,
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }

        return false;
    }

    public function editar($id, $descripcion)
    {
        $stmt = $this->db->prepare("UPDATE
                                        `incidencias`
                                    SET
                                        `descripcion` = :descripcion
                                    WHERE
                                        `id` = :id");

        return $stmt->execute([
            'descripcion' => $descripcion,
            'id' => $id
        ]);
    }

    public function marcar_solucionada($id){
        $stmt = $this->db->prepare("UPDATE
                                        `incidencias`
                                    SET
                                        `estado` = 1,
                                        `fecha_solucionada` = NOW()
                                    WHERE
                                        `id`=:id");

        return $stmt->execute([
            'id' => $id
        ]);
    }
}