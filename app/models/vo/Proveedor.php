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
    public string $fecha_creado;
    public string $fecha_editado;
    public string | null $fecha_baja;
    public float $limite;
    public Usuario $usuario;

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
        string | null $fecha_baja,
        float $limite,
        string $fecha_creado,
        string $fecha_editado,
        Usuario $usuario
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
        $this->fecha_baja = $fecha_baja;
        $this->limite = $limite;
        $this->fecha_creado = $fecha_creado;
        $this->fecha_editado = $fecha_editado;
        $this->usuario = $usuario;
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
            $row['proveedor_fecha_baja'],
            $row['proveedor_limite'],
            $row['proveedor_fecha_creado'],
            $row['proveedor_fecha_editado'],
            Usuario::fromArray($row)
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

    public function getFechaCreadoVisible()
    {
        $date = new DateTime($this->fecha_creado);
        return $date->format('d/m/Y h:i');
    }

    public function getFechaEditadoVisible()
    {
        $date = new DateTime($this->fecha_editado);
        return $date->format('d/m/Y h:i');
    }

    public function getFechaBorradoVisible()
    {
        $date = new DateTime($this->fecha_baja);
        return $date->format('d/m/Y');
    }

    public function getEstado(){
        return is_null($this->fecha_baja) ? 'Activo' : 'Baja';
    }
}