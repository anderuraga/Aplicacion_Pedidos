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

    public function obtener($id): Proveedor
    {
        $stmt = $this->db->prepare("SELECT 
                                                p.`id` as proveedor_id, 
                                                p.`cif` as proveedor_cif, 
                                                p.`nombre` as proveedor_nombre, 
                                                p.`direccion` as proveedor_direccion, 
                                                p.`cod_postal` as proveedor_cod_postal, 
                                                p.`poblacion` as proveedor_poblacion, 
                                                p.`provincia` as proveedor_provincia, 
                                                p.`pais` as proveedor_pais, 
                                                p.`telefono` as proveedor_telefono, 
                                                p.`correo` as proveedor_correo, 
                                                p.`factura_e` as proveedor_factura_e, 
                                                p.`cuanta_bancaria` as proveedor_cuenta_bancaria, 
                                                p.`contacto` as proveedor_contacto, 
                                                p.`id_servicio` as tiposervicio_id,
                                                t.nombre as tiposervicio_nombre
                                            FROM `proveedores` p 
                                                JOIN tipos_servicio t 
                                                    ON t.id=p.id_servicio 
                                            WHERE p.id=:id
                                            ORDER BY p.cif ASC");

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return Proveedor::fromArray($row);
    }

    public function comprobrarCif($cif, $excluirId = null)
    {
         // TODO cambiar * por un id
        $sql = "SELECT COUNT(*) FROM proveedores WHERE `cif` = :cif";
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

    public function listar()
    {
        $stmt = $this->db->query("SELECT 
                                        p.`id` as proveedor_id, 
                                        p.`cif` as proveedor_cif, 
                                        p.`nombre` as proveedor_nombre, 
                                        p.`direccion` as proveedor_direccion, 
                                        p.`cod_postal` as proveedor_cod_postal, 
                                        p.`poblacion` as proveedor_poblacion, 
                                        p.`provincia` as proveedor_provincia, 
                                        p.`pais` as proveedor_pais, 
                                        p.`telefono` as proveedor_telefono, 
                                        p.`correo` as proveedor_correo, 
                                        p.`factura_e` as proveedor_factura_e, 
                                        p.`cuanta_bancaria` as proveedor_cuenta_bancaria, 
                                        p.`contacto` as proveedor_contacto, 
                                        p.`id_servicio` as tiposervicio_id,
                                        t.nombre as tiposervicio_nombre
                                    FROM `proveedores` p 
                                    JOIN tipos_servicio t 
                                        ON t.id=p.id_servicio 
                                WHERE 1
                                ORDER BY p.cif ASC");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = Proveedor::fromArray($row);
        }

        return $result;
    }
}