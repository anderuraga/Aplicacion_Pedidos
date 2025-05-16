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
                                            ts.nombre AS tiposervicio_nombre,
                                            vpg.anio_contable,
                                            vpg.gasto_anual
                                        FROM 
                                            vista_proveedores_gastos vpg
                                        JOIN 
                                            tipos_servicio ts ON ts.id = vpg.id_servicio
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
        $sql = "INSERT INTO proveedores
            (cif,nombre,direccion,cod_postal,poblacion,provincia,pais,telefono,correo,factura_e,cuanta_bancaria,contacto,id_servicio)
            VALUES
            (:cif,:nombre,:direccion,:cod_postal,:poblacion,:provincia,:pais,:telefono,:correo,:factura_e,:cuenta_bancaria,:contacto,:id_servicio)";
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
            'id_servicio' => $data['id_servicio']
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
            id_servicio    = :id_servicio
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
            'id_servicio' => $data['id_servicio']
        ]);
    }

    public function listar($anio = null)
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
                                            ts.nombre AS tiposervicio_nombre,
                                            vpg.anio_contable,
                                            vpg.gasto_anual
                                        FROM 
                                            vista_proveedores_gastos vpg
                                        JOIN 
                                            tipos_servicio ts ON ts.id = vpg.id_servicio
                                        WHERE 
                                            vpg.anio_contable = :anio_contable
                                        ORDER BY 
                                            vpg.cif ASC;");

        $anio_contable = is_null($anio) ? date('Y') : intval($anio);
        $stmt->execute(['anio_contable' => $anio_contable]);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Proveedor::fromArray($row);
        }

        return $result;
    }
}