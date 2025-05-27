<?php
require_once __DIR__ . '/../../helpers/formatos.php';
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
    public float $gasto_anual;
    public string | null $terceros;
    public string | null $prov_prof;
    public string | null $fecha_baja;

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
        TipoServicio $tipoServicio,
        float $gasto_anual,
        string | null $terceros,
        string | null $prov_prof,
        string | null $fecha_baja
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
        $this->tipo_servicio = $tipoServicio;
        $this->gasto_anual = $gasto_anual;
        $this->terceros = $terceros;
        $this->prov_prof = $prov_prof;
    }

    public static function fromArray(array $row): Proveedor
    {
        return new Proveedor(
            (int) $row['proveedor_id'],
            $row['proveedor_cif'],
            $row['proveedor_nombre'],
            $row['proveedor_direccion'],
            (int) $row['proveedor_cod_postal'],
            $row['proveedor_poblacion'],
            $row['proveedor_provincia'],
            $row['proveedor_pais'],
            $row['proveedor_telefono'],
            $row['proveedor_correo'],
            $row['proveedor_factura_e']==1,
            $row['proveedor_cuenta_bancaria'],
            $row['proveedor_contacto'],
            TipoServicio::fromArray($row),
            $row['gasto_anual'],
            $row['proveedor_terceros'],
            $row['proveedor_prov_prof'],
            $row['proveedor_fecha_baja']
        );
    }

    public function cantidad_formato()
    {
        return getCantidadFormateada($this->gasto_anual);
    }

    public function direccion_completa()
    {
        return $this->direccion.", ".$this->cod_postal.", ".$this->poblacion.", ".$this->provincia.", ".$this->pais;
    }

    public function getFechaVisible()
    {
        $date = new DateTime($this->fecha);
        return $date->format('d/m/Y');
    }
}