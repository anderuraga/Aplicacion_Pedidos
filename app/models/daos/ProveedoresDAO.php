<?php
require_once __DIR__ . '/../../../core/Database.php';
require_once __DIR__ . '/../vo/Proveedor.php';

class ProveedoresDAO
{
    private $db;
    public $last_insert;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function obtener($id, $anio = null): Proveedor
    {
        $stmt = $this->db->prepare("SELECT
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
    vpg.proveedor_terceros AS proveedor_terceros,
    vpg.proveedor_fecha_creado AS proveedor_fecha_creado,
    vpg.proveedor_fecha_editado AS proveedor_fecha_editado,
    vpg.proveedor_fecha_baja AS proveedor_fecha_baja,
    vpg.proveedor_limite AS proveedor_limite,
    ts.nombre AS tiposervicio_nombre,
    vpg.anio_contable,
    vpg.gasto_anual,
    vpg.usuario_id AS usuario_id,
    u.tipo AS usuario_tipo,
    u.nombre AS usuario_nombre,
    u.correo AS usuario_correo,
    u.id_departamento AS departamento_id,
    d.nombre AS departamento_nombre
FROM
    vista_proveedores_gastos vpg
JOIN tipos_servicio ts ON
    ts.id = vpg.id_servicio
JOIN usuarios u ON
    u.id = vpg.usuario_id
JOIN departamentos d ON
    u.id_departamento = d.id
WHERE
    vpg.id = :id
    AND vpg.anio_contable = :anio_contable
ORDER BY 
    vpg.cif ASC;");

        $anio_contable = is_null($anio) ? date('Y') : intval($anio);
        $stmt->execute(['id' => $id, 'anio_contable' => $anio_contable]);
        $row = $stmt->fetch();
        return Proveedor::fromArray($row);
    }

    public function comprobrarCif($cif, $excluirId = null)
    {
        $sql = "SELECT COUNT(id) FROM proveedores WHERE `cif` = :cif";
        if ($excluirId !== null) {
            $sql .= " AND id != :id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cif', $cif);
        if ($excluirId !== null) {
            $stmt->bindValue(':id', $excluirId);
        }
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function comprobarId($id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM proveedores WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear(array $data): bool
    {
        $sql = "INSERT INTO proveedores(
    cif,
    nombre,
    direccion,
    cod_postal,
    poblacion,
    provincia,
    pais,
    telefono,
    correo,
    factura_e,
    cuanta_bancaria,
    contacto,
    id_servicio,
    usuario_id,
    limite
)
VALUES(
    :cif,
    :nombre,
    :direccion,
    :cod_postal,
    :poblacion,
    :provincia,
    :pais,
    :telefono,
    :correo,
    :factura_e,
    :cuenta_bancaria,
    :contacto,
    :id_servicio,
    :usuario_id,
    :limite
)";
        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            'cif' => $data['cif'],
            'nombre' => $data['nombre'],
            'direccion' => $data['direccion'],
            'cod_postal' => $data['cod_postal'],
            'poblacion' => $data['poblacion'],
            'provincia' => $data['provincia'],
            'pais' => $data['pais'],
            'telefono' => $data['telefono'],
            'correo' => $data['correo'],
            'factura_e' => $data['factura_e'],
            'cuenta_bancaria' => $data['cuenta_bancaria'],
            'contacto' => $data['contacto'],
            'id_servicio' => $data['id_servicio'],
            'usuario_id' => $data['usuario_id'],
            'limite' => $data['limite'],
        ]);

        if ($ok) {
            $this->last_insert = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    public function editar(int $id, array $data): bool
    {
        $sql = "UPDATE proveedores SET
            cif            = :cif,
            nombre         = :nombre,
            direccion      = :direccion,
            cod_postal     = :cod_postal,
            poblacion      = :poblacion,
            provincia      = :provincia,
            pais           = :pais,
            telefono       = :telefono,
            correo         = :correo,
            factura_e      = :factura_e,
            cuanta_bancaria= :cuenta_bancaria,
            contacto       = :contacto,
            id_servicio    = :id_servicio,
            limite         = :limite,
            fecha_editado  = NOW()
            WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'cif' => $data['cif'],
            'nombre' => $data['nombre'],
            'direccion' => $data['direccion'],
            'cod_postal' => $data['cod_postal'],
            'poblacion' => $data['poblacion'],
            'provincia' => $data['provincia'],
            'pais' => $data['pais'],
            'telefono' => $data['telefono'],
            'correo' => $data['correo'],
            'factura_e' => $data['factura_e'],
            'cuenta_bancaria' => $data['cuenta_bancaria'],
            'contacto' => $data['contacto'],
            'id_servicio' => $data['id_servicio'],
            'limite' => $data['limite'],
        ]);
    }

    public function listar($activos = false, $anio = null)
    {
        $sql = "
        SELECT
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
            vpg.proveedor_terceros AS proveedor_terceros,
            vpg.proveedor_fecha_creado AS proveedor_fecha_creado,
            vpg.proveedor_fecha_editado AS proveedor_fecha_editado,
            vpg.proveedor_fecha_baja AS proveedor_fecha_baja,
            vpg.proveedor_limite AS proveedor_limite,
            ts.nombre AS tiposervicio_nombre,
            vpg.anio_contable,
            vpg.gasto_anual,
            vpg.usuario_id AS usuario_id,
            u.tipo AS usuario_tipo,
            u.nombre AS usuario_nombre,
            u.correo AS usuario_correo,
            u.id_departamento AS departamento_id,
            d.nombre AS departamento_nombre
        FROM
            vista_proveedores_gastos vpg
        JOIN tipos_servicio ts ON ts.id = vpg.id_servicio
        JOIN usuarios u ON u.id = vpg.usuario_id
        JOIN departamentos d ON u.id_departamento = d.id
        WHERE
            vpg.anio_contable = :anio_contable
    ";

        if ($activos) {
            $sql .= " AND vpg.proveedor_fecha_baja IS NULL";
        }

        $sql .= " ORDER BY vpg.cif ASC;";

        $stmt = $this->db->prepare($sql);

        $anio_contable = is_null($anio) ? date('Y') : intval($anio);
        $stmt->execute(['anio_contable' => $anio_contable]);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Proveedor::fromArray($row);
        }

        return $result;
    }

    public function listar_usuario($usuario, $activos = false, $anio = null)
    {
        $sql = "
        SELECT
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
            vpg.proveedor_terceros AS proveedor_terceros,
            vpg.proveedor_fecha_creado AS proveedor_fecha_creado,
            vpg.proveedor_fecha_editado AS proveedor_fecha_editado,
            vpg.proveedor_fecha_baja AS proveedor_fecha_baja,
            vpg.proveedor_limite AS proveedor_limite,
            ts.nombre AS tiposervicio_nombre,
            vpg.anio_contable,
            vpg.gasto_anual,
            vpg.usuario_id AS usuario_id,
            u.tipo AS usuario_tipo,
            u.nombre AS usuario_nombre,
            u.correo AS usuario_correo,
            u.id_departamento AS departamento_id,
            d.nombre AS departamento_nombre
        FROM
            vista_proveedores_gastos vpg
        JOIN tipos_servicio ts ON ts.id = vpg.id_servicio
        JOIN usuarios u ON u.id = vpg.usuario_id
        JOIN departamentos d ON u.id_departamento = d.id
        WHERE
            vpg.anio_contable = :anio_contable AND
            vpg.usuario_id = :usuario
    ";

        if ($activos) {
            $sql .= " AND vpg.proveedor_fecha_baja IS NULL";
        }

        $sql .= " ORDER BY vpg.cif ASC;";

        $stmt = $this->db->prepare($sql);

        $anio_contable = is_null($anio) ? date('Y') : intval($anio);
        $stmt->execute([
            'usuario' => $usuario,
            'anio_contable' => $anio_contable
        ]);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Proveedor::fromArray($row);
        }

        return $result;
    }

    public function baja($id)
    {
        $stmt = $this->db->prepare("UPDATE `proveedores` SET `fecha_baja`=NOW(), fecha_editado  = NOW() WHERE id=:id");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function alta($id)
    {
        $stmt = $this->db->prepare("UPDATE `proveedores` SET `fecha_baja`=NULL, fecha_editado  = NOW() WHERE `id`=:id");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function insertar_alta_terceros($id, $documento)
    {
        $stmt = $this->db->prepare("UPDATE `proveedores` SET `terceros`=:terceros, fecha_editado  = NOW() WHERE `id`=:id");

        return $stmt->execute([
            'terceros' => $documento,
            'id' => $id
        ]);
    }

    public function reportes($anio)
    {
        $sql = "SELECT
                ts.id AS id_tipo_servicio,
                ts.nombre      AS tipo_servicio,
                pr.id          AS id_proveedor,
                pr.nombre      AS nombre_proveedor,
                COUNT(p.id)    AS num_pedidos,
                SUM(p.importe) AS total_importe
                FROM proveedores pr
                JOIN tipos_servicio ts
                    ON pr.id_servicio = ts.id
                JOIN pedidos p
                    ON p.id_proveedor = pr.id
                    AND p.anio_contable = :anio
                GROUP BY ts.id, pr.id, pr.nombre;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'anio' => $anio
        ]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row["total_importe"] = getCantidadFormateada((float) $row['total_importe']);
            $result[] = $row;
        }

        return $result;
    }

    public function borrar($id, $nombre, $cif)
    {
        $sql = "UPDATE
            `proveedores`
        SET
            `cif` = :cif,
            `nombre` = :nombre,
            `direccion` = :nombre,
            `cod_postal` = 0,
            `poblacion` = :nombre,
            `provincia` = :nombre,
            `pais` = :nombre,
            `telefono` = :nombre,
            `correo` = :nombre,
            `factura_e` = 1,
            `cuanta_bancaria` = 0,
            `contacto` = :nombre,
            `terceros` = null,
            `fecha_creado` = NOW(),
            `fecha_editado` = NOW(),
            `fecha_baja` = NOW(),
            `limite` = 0,
            `borrado` = NOW()
        WHERE
            `id` = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'cif' => $cif,
            'nombre' => $nombre
        ]);
    }

    
    /*

    Nueva tabla para poder subir documentos en los proveedores

            CREATE TABLE `otros_documentos_proveedor` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `id_proveedor` INT(11) NOT NULL DEFAULT '0',
            `tipo` VARCHAR(255) NOT NULL DEFAULT '0',
            `documento` VARCHAR(255) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
            )
            COLLATE='utf8mb4_general_ci'
            ;

    */

      public function subir_otro_doc($proveedor, $tipo, $documento)
    {
        $sql = "INSERT INTO `otros_documentos_proveedor`(`id_proveedor`, `tipo`, `documento`)
                VALUES(:proveedor, :tipo, :documento)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'proveedor' => $proveedor,
            'tipo' => $tipo,
            'documento' => $documento
        ]);
    }



    public function obtener_otros_docs($proveedor)
    {
        $sql = "SELECT
                    `id`,
                    `tipo`,
                    `documento`
                FROM
                    `otros_documentos_proveedor`
                WHERE
                    `id_proveedor` = :proveedor
                ORDER BY
                    `id` ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'proveedor' => $proveedor
        ]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }

    public function obtener_otro_doc($id)
    {
        $sql = "SELECT `id`, `id_proveedor`, `tipo`, `documento` FROM `otros_documentos_proveedor` WHERE `id`=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function borrar_otro_doc($id)
    {
        $sql = "DELETE FROM `otros_documentos_proveedor` WHERE `id`=:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id
        ]);
    }

}