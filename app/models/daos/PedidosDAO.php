<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Pedido.php';
require_once __DIR__ . '/../vo/Presupuesto.php';
require_once __DIR__ . '/../vo/Historial.php';

class PedidosDAO
{
    private $db;
    public $last_insert;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id): Pedido
    {
        $sql = "SELECT
                p.id AS pedido_id,
                p.referencia AS pedido_referencia,
                e.id AS estado_id,
                e.nombre AS estado_nombre,
                e.icono,
                u.id AS usuario_id,
                u.tipo AS usuario_tipo,
                u.nombre AS usuario_nombre,
                u.correo AS usuario_correo,
                d.id AS departamento_id,
                d.nombre AS departamento_nombre,
                s.id AS subconcepto_id,
                s.nombre AS subconcepto_nombre,
                s.tipo AS subconcepto_tipo,
                a.id_area AS area_id,
                a.nombre_area AS area_nombre,
                a.ingresos AS ingresos,
                a.gastos AS gastos,
                a.gasto_pendiente AS gasto_pendiente,
                a.total AS diferencia,
                vpg.id AS proveedor_id,
                vpg.cif AS proveedor_cif,
                vpg.nombre AS proveedor_nombre,
                vpg.direccion AS proveedor_direccion,
                vpg.cod_postal AS proveedor_cod_postal,
                vpg.poblacion AS proveedor_poblacion,
                vpg.provincia AS proveedor_provincia,
                vpg.pais AS proveedor_pais,
                vpg.telefono AS proveedor_telefono,
                vpg.correo AS proveedor_correo,
                vpg.factura_e AS proveedor_factura_e,
                vpg.cuanta_bancaria AS proveedor_cuenta_bancaria,
                vpg.contacto AS proveedor_contacto,
                vpg.id_servicio AS tiposervicio_id,
                ts.nombre AS tiposervicio_nombre,
                vpg.gasto_anual AS gasto_anual,
                p.fecha_creada AS pedido_fecha_creada,
                p.fecha_enviada AS pedido_fecha_enviada,
                p.descripcion AS pedido_descripcion,
                p.importe AS pedido_importe,
                p.id_factura AS pedido_factura_id,
                p.anio_contable AS pedido_anio_contable,
                p.anexo AS pedido_anexo,
                p.albaran AS pedido_albaran,
                p.factura AS pedido_factura
            FROM
                `pedidos` p
            JOIN estado e ON
                e.id = p.id_estado
            JOIN usuarios u ON
                u.id = p.id_usuario
            JOIN departamentos d ON
                d.id = p.id_departamento
            JOIN subconceptos s ON
                s.id = p.id_subconcepto
            JOIN vista_resumen_areas a ON
                a.id_area = p.id_area_gasto
            JOIN vista_proveedores_gastos vpg ON
                vpg.id = p.id_proveedor AND vpg.anio_contable = p.anio_contable
            JOIN tipos_servicio ts ON
                ts.id = vpg.id_servicio
            WHERE
                    p.id = :id
                ORDER BY
                    p.referencia DESC
                    ";
        $stmt = $this->db->prepare($sql);

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Pedido::fromArray($row);
    }

    public function listar_estado($id_estado)
    {
        $sql = "SELECT
                p.id AS pedido_id,
                p.referencia AS pedido_referencia,
                e.id AS estado_id,
                e.nombre AS estado_nombre,
                e.icono,
                u.id AS usuario_id,
                u.tipo AS usuario_tipo,
                u.nombre AS usuario_nombre,
                u.correo AS usuario_correo,
                d.id AS departamento_id,
                d.nombre AS departamento_nombre,
                s.id AS subconcepto_id,
                s.nombre AS subconcepto_nombre,
                s.tipo AS subconcepto_tipo,
                a.id_area AS area_id,
                a.nombre_area AS area_nombre,
                a.ingresos AS ingresos,
                a.gastos AS gastos,
                a.gasto_pendiente AS gasto_pendiente,
                a.total AS diferencia,
                vpg.id AS proveedor_id,
                vpg.cif AS proveedor_cif,
                vpg.nombre AS proveedor_nombre,
                vpg.direccion AS proveedor_direccion,
                vpg.cod_postal AS proveedor_cod_postal,
                vpg.poblacion AS proveedor_poblacion,
                vpg.provincia AS proveedor_provincia,
                vpg.pais AS proveedor_pais,
                vpg.telefono AS proveedor_telefono,
                vpg.correo AS proveedor_correo,
                vpg.factura_e AS proveedor_factura_e,
                vpg.cuanta_bancaria AS proveedor_cuenta_bancaria,
                vpg.contacto AS proveedor_contacto,
                vpg.id_servicio AS tiposervicio_id,
                ts.nombre AS tiposervicio_nombre,
                vpg.gasto_anual AS gasto_anual,
                p.fecha_creada AS pedido_fecha_creada,
                p.fecha_enviada AS pedido_fecha_enviada,
                p.descripcion AS pedido_descripcion,
                p.importe AS pedido_importe,
                p.id_factura AS pedido_factura_id,
                p.anio_contable AS pedido_anio_contable,
                p.anexo AS pedido_anexo,
                p.albaran AS pedido_albaran,
                p.factura AS pedido_factura
            FROM
                `pedidos` p
            JOIN estado e ON
                e.id = p.id_estado
            JOIN usuarios u ON
                u.id = p.id_usuario
            JOIN departamentos d ON
                d.id = p.id_departamento
            JOIN subconceptos s ON
                s.id = p.id_subconcepto
            JOIN vista_resumen_areas a ON
                a.id_area = p.id_area_gasto
            JOIN vista_proveedores_gastos vpg ON
                vpg.id = p.id_proveedor AND vpg.anio_contable = p.anio_contable
            JOIN tipos_servicio ts ON
                ts.id = vpg.id_servicio
            WHERE
                p.id_estado = :id_estado
            ORDER BY
                p.referencia DESC
                    ";
        $stmt = $this->db->prepare($sql);

        $stmt->execute(['id_estado' => $id_estado]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Pedido::fromArray($row);
        }
        return $result;
    }

    public function listar_estado_departamento($id_estado, $id_departamento)
    {
        $sql = "SELECT
                p.id AS pedido_id,
                p.referencia AS pedido_referencia,
                e.id AS estado_id,
                e.nombre AS estado_nombre,
                e.icono,
                u.id AS usuario_id,
                u.tipo AS usuario_tipo,
                u.nombre AS usuario_nombre,
                u.correo AS usuario_correo,
                d.id AS departamento_id,
                d.nombre AS departamento_nombre,
                s.id AS subconcepto_id,
                s.nombre AS subconcepto_nombre,
                s.tipo AS subconcepto_tipo,
                a.id_area AS area_id,
                a.nombre_area AS area_nombre,
                a.ingresos AS ingresos,
                a.gastos AS gastos,
                a.gasto_pendiente AS gasto_pendiente,
                a.total AS diferencia,
                vpg.id AS proveedor_id,
                vpg.cif AS proveedor_cif,
                vpg.nombre AS proveedor_nombre,
                vpg.direccion AS proveedor_direccion,
                vpg.cod_postal AS proveedor_cod_postal,
                vpg.poblacion AS proveedor_poblacion,
                vpg.provincia AS proveedor_provincia,
                vpg.pais AS proveedor_pais,
                vpg.telefono AS proveedor_telefono,
                vpg.correo AS proveedor_correo,
                vpg.factura_e AS proveedor_factura_e,
                vpg.cuanta_bancaria AS proveedor_cuenta_bancaria,
                vpg.contacto AS proveedor_contacto,
                vpg.id_servicio AS tiposervicio_id,
                ts.nombre AS tiposervicio_nombre,
                vpg.gasto_anual AS gasto_anual,
                p.fecha_creada AS pedido_fecha_creada,
                p.fecha_enviada AS pedido_fecha_enviada,
                p.descripcion AS pedido_descripcion,
                p.importe AS pedido_importe,
                p.id_factura AS pedido_factura_id,
                p.anio_contable AS pedido_anio_contable,
                p.anexo AS pedido_anexo,
                p.albaran AS pedido_albaran,
                p.factura AS pedido_factura
            FROM
                `pedidos` p
            JOIN estado e ON
                e.id = p.id_estado
            JOIN usuarios u ON
                u.id = p.id_usuario
            JOIN departamentos d ON
                d.id = p.id_departamento
            JOIN subconceptos s ON
                s.id = p.id_subconcepto
            JOIN vista_resumen_areas a ON
                a.id_area = p.id_area_gasto
            JOIN vista_proveedores_gastos vpg ON
                vpg.id = p.id_proveedor AND vpg.anio_contable = p.anio_contable
            JOIN tipos_servicio ts ON
                ts.id = vpg.id_servicio
            WHERE
                p.id_estado = :id_estado AND
                p.id_departamento = :id_departamento
            ORDER BY
                p.referencia DESC
                    ";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id_estado' => $id_estado,
            'id_departamento' => $id_departamento
        ]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Pedido::fromArray($row);
        }
        return $result;
    }

    public function crear(array $data): bool
    {
        $sql = "INSERT INTO pedidos(
    referencia,
    id_estado,
    id_usuario,
    id_departamento,
    id_subconcepto,
    id_area_gasto,
    id_proveedor,
    descripcion,
    importe,
    anio_contable
)
VALUES(
    :referencia,
    1,
    :id_usuario,
    :id_departamento,
    :id_subconcepto,
    :id_area_gasto,
    :id_proveedor,
    :descripcion,
    :importe,
    :anio_contable
)";

        $stmt = $this->db->prepare($sql);

        $referencia = $this->generarReferencia($data['id_area_gasto']);
        $ok = $stmt->execute([
            'referencia' => $referencia,
            'id_usuario' => $data['id_usuario'],
            'id_departamento' => $data['id_departamento'],
            'id_subconcepto' => $data['id_subconcepto'],
            'id_area_gasto' => $data['id_area_gasto'],
            'id_proveedor' => $data['id_proveedor'],
            'descripcion' => $data['descripcion'],
            'importe' => $data['importe'],
            'anio_contable' => $data['anio_contable']
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    private function generarReferencia(int $id_area_gasto): string
    {
        $fecha = date('Ymd');
        $aleatorio = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
        return "{$id_area_gasto}-{$fecha}-{$aleatorio}";
    }

    public function insertar_presupuestos($datos)
    {
        $stmt = $this->db->prepare("INSERT INTO presupuestos(
    id_pedido,
    documento,
    seleccionado
)
VALUES(
    :id_pedido,
    :documento,
    :seleccionado
)");

        return $stmt->execute([
            'id_pedido' => $datos['id_pedido'],
            'documento' => $datos['documento'],
            'seleccionado' => $datos['seleccionado']
        ]);
    }
    public function insertar_anexo($id_pedido, $documento)
    {
        $stmt = $this->db->prepare("UPDATE `pedidos` SET `anexo`=:anexo WHERE `id`=:id");

        return $stmt->execute([
            'anexo' => $documento,
            'id' => $id_pedido
        ]);
    }

    public function insertar_albaran($id_pedido, $documento)
    {
        $stmt = $this->db->prepare("UPDATE `pedidos` SET `albaran`=:albaran  WHERE `id`=:id");

        return $stmt->execute([
            'albaran' => $documento,
            'id' => $id_pedido
        ]);
    }

    public function insertar_factura($id_pedido, $documento)
    {
        $stmt = $this->db->prepare("UPDATE `pedidos` SET `factura`=:factura  WHERE `id`=:id");

        return $stmt->execute([
            'factura' => $documento,
            'id' => $id_pedido
        ]);
    }

    public function obtener_presupuestos($id)
    {
        $stmt = $this->db->prepare("SELECT
    `id` as presupuesto_id,
    `documento` as presupuesto_documento,
    `fecha` as presupuesto_fecha,
    `seleccionado` as presupuesto_seleccionado
FROM
    `presupuestos`
WHERE
    `id_pedido` = :id
ORDER BY
    `seleccionado` DESC,
    `id` DESC
    ");

        $stmt->execute(['id' => $id]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Presupuesto::fromArray($row);
        }
        return $result;
    }

    public function obtener_historial($id)
    {
        $stmt = $this->db->prepare("SELECT
    `id` as historial_id,
    `fecha` as historial_fecha,
    `comentario` as historial_comentario
FROM
    `pedidos_estados`
WHERE
    `id_pedido` = :id_pedido
ORDER BY
    `fecha`
DESC
    ");

        $stmt->execute(['id_pedido' => $id]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Historial::fromArray($row);
        }
        return $result;
    }

    public function cambiarEstado($pedido, $estado)
    {
        $stmt = $this->db->prepare("UPDATE `pedidos` SET `id_estado`=:estado WHERE `id`=:pedido");
        return $stmt->execute([
            'estado' => $estado,
            'pedido' => $pedido
        ]);
    }

    public function rellenarEstado($id_estado, $id_pedido, $comentario)
    {
        $stmt = $this->db->prepare("INSERT INTO `pedidos_estados`(`id_estado`, `id_pedido`, `comentario`) VALUES (:id_estado,:id_pedido,:comentario)");
        return $stmt->execute([
            'id_estado' => $id_estado,
            'id_pedido' => $id_pedido,
            'comentario' => $comentario
        ]);
    }
}
