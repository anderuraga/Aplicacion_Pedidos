<?php
require_once __DIR__ . '/TipoServicio.php';
class Proveedor
{
    public int $id;
    public string $cif;
    public string $nombre;
    public string $direccion;
    public int $cod_postal;
    public string $poblacion;
    public string $provincia;
    public string $pais;
    public string $telefono;
    public string $correo;
    public bool $factura_electronica;
    public string $cuenta_bancaria;
    public string $contacto;
    public TipoServicio $tipo_servicio;

    public function __construct(
        int $id,
        string $cif,
        string $nombre,
        string $direccion,
        int $cod_postal,
        string $poblacion,
        string $provincia,
        string $pais,
        string $telefono,
        string $correo,
        bool $factura_electronica,
        string $cuenta_bancaria,
        string $contacto,
        int $tipo_servicio_id,
        string $tipo_servicio_nombre
    ) {
        $this->id = $id;
        $this->cif = $cif;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->cod_postal = $cod_postal;
        $this->poblacion = $poblacion;
        $this->provincia = $provincia;
        $this->pais = $pais;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->factura_electronica = $factura_electronica;
        $this->cuenta_bancaria = $cuenta_bancaria;
        $this->contacto = $contacto;
        $this->tipo_servicio = new TipoServicio($tipo_servicio_id, $tipo_servicio_nombre);
    }
}