<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Pedido.php';

class PedidosDAO
{
    private $db;
    public $last_insert;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id): Proveedor
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
                    a.total AS diferencia,
                    pr.id AS proveedor_id,
                    pr.cif AS proveedor_cif,
                    pr.nombre AS proveedor_nombre,
                    pr.direccion AS proveedor_direccion,
                    pr.cod_postal AS proveedor_cod_postal,
                    pr.poblacion AS proveedor_poblacion,
                    pr.provincia AS proveedor_provincia,
                    pr.pais AS proveedor_pais,
                    pr.telefono AS proveedor_telefono,
                    pr.correo AS proveedor_correo,
                    pr.factura_e AS proveedor_factura_e,
                    pr.cuanta_bancaria AS proveedor_cuenta_bancaria,
                    pr.contacto AS proveedor_contacto,
                    ts.id AS tiposervicio_id,
                    ts.nombre AS tiposervicio_nombre,
                    p.fecha_creada AS pedido_fecha_creada,
                    p.fecha_enviada AS pedido_fecha_enviada,
                    p.descripcion AS pedido_descripcion,
                    p.importe AS pedido_importe,
                    p.id_factura AS pedido_factura_id,
                    p.anio_contable AS pedido_anio_contable
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
                JOIN proveedores pr ON
                    pr.id = p.id_proveedor
                JOIN tipos_servicio ts ON
                    ts.id = pr.id_servicio
                WHERE
                    p.id = :id
                ORDER BY
                    p.referencia DESC
                    ";
        $stmt = $this->db->prepare($sql);

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Proveedor::fromArray($row);
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
                    a.total AS diferencia,
                    pr.id AS proveedor_id,
                    pr.cif AS proveedor_cif,
                    pr.nombre AS proveedor_nombre,
                    pr.direccion AS proveedor_direccion,
                    pr.cod_postal AS proveedor_cod_postal,
                    pr.poblacion AS proveedor_poblacion,
                    pr.provincia AS proveedor_provincia,
                    pr.pais AS proveedor_pais,
                    pr.telefono AS proveedor_telefono,
                    pr.correo AS proveedor_correo,
                    pr.factura_e AS proveedor_factura_e,
                    pr.cuanta_bancaria AS proveedor_cuenta_bancaria,
                    pr.contacto AS proveedor_contacto,
                    ts.id AS tiposervicio_id,
                    ts.nombre AS tiposervicio_nombre,
                    p.fecha_creada AS pedido_fecha_creada,
                    p.fecha_enviada AS pedido_fecha_enviada,
                    p.descripcion AS pedido_descripcion,
                    p.importe AS pedido_importe,
                    p.id_factura AS pedido_factura_id,
                    p.anio_contable AS pedido_anio_contable
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
                JOIN proveedores pr ON
                    pr.id = p.id_proveedor
                JOIN tipos_servicio ts ON
                    ts.id = pr.id_servicio
                WHERE
                    p.id_estado=:id_estado
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
}