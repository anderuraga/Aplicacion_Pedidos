<?php
require_once __DIR__ . '/../../helpers/formatos.php';
require_once __DIR__ . '/Estado.php';
require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Departamento.php';
require_once __DIR__ . '/Subconcepto.php';
require_once __DIR__ . '/AreaGastos.php';
require_once __DIR__ . '/Proveedor.php';
require_once __DIR__ . '/Factura.php';
require_once __DIR__ . '/Transaccion.php';

class Pedido
{
    public int $id;
    public string $referencia;
    public Estado $estado;
    public Usuario $usuario;
    public Departamento $departamento;
    public Subconcepto $subconcepto;
    public AreaGastos $areaGastos;
    public Proveedor $proveedor;
    public string $fecha_creada;
    public string|null $fecha_enviada;
    public string $descripcion;
    public string $importe;
    public string $importe_sin_iva;
    public Factura $factura;
    public int $anio_contable;
    public string | null $anexo;
    public string | null $albaran;
    public Transaccion | null $transaccion;

    public function __construct(
        int $id,
        string $referencia,
        Estado $estado,
        Usuario $usuario,
        Departamento $departamento,
        Subconcepto $subconcepto,
        AreaGastos $areaGastos,
        Proveedor $proveedor,
        string $fecha_creada,
        string|null $fecha_enviada,
        string $descripcion,
        string $importe,
        string $importe_sin_iva,
        Factura $factura,
        int $anio_contable,
        string | null $anexo,
        string | null $albaran,
        Transaccion | null $transaccion
    ) {
        $this->id = $id;
        $this->referencia = $referencia;
        $this->estado = $estado;
        $this->usuario = $usuario;
        $this->departamento = $departamento;
        $this->subconcepto = $subconcepto;
        $this->areaGastos = $areaGastos;
        $this->proveedor = $proveedor;
        $this->fecha_creada = $fecha_creada;
        $this->fecha_enviada = $fecha_enviada;
        $this->descripcion = $descripcion;
        $this->importe = $importe;
        $this->importe_sin_iva = $importe_sin_iva;
        $this->factura = $factura;
        $this->anio_contable = $anio_contable;
        $this->anexo = $anexo;
        $this->albaran = $albaran;
        $this->transaccion = $transaccion;
    }

    public static function fromArray(array $row): Pedido
    {
        return new Pedido(
            id: (int) $row['pedido_id'],
            referencia: $row['pedido_referencia'],
            estado: Estado::fromArray($row),
            usuario: Usuario::fromArray($row),
            departamento: Departamento::fromArray($row),
            subconcepto: Subconcepto::fromArray($row),
            areaGastos: AreaGastos::fromArray($row),
            proveedor: Proveedor::fromArray($row),
            fecha_creada: $row['pedido_fecha_creada'],
            fecha_enviada: $row['pedido_fecha_enviada'],
            descripcion: $row['pedido_descripcion'],
            importe: (float) $row['pedido_importe'],
            importe_sin_iva: (float) $row['pedido_importe_sin_iva'],
            factura: Factura::fromArray($row),
            anio_contable: (int) $row['pedido_anio_contable'],
            anexo: $row['pedido_anexo'],
            albaran: $row['pedido_albaran'],
            transaccion: Transaccion::fromArray($row)
        );
    }

    public function getFechaCreadaVisible()
    {
        $date = new DateTime($this->fecha_creada);
        return $date->format('d/m/Y');
    }

    public function getFechaEnviadaVisible()
    {
        $date = new DateTime($this->fecha_enviada);
        return $date->format('d/m/Y');
    }

    public function cantidad_formato()
    {
        return getCantidadFormateada($this->importe);
    }
    public function cantidad_sin_iva_formato()
    {
        return getCantidadFormateada($this->importe_sin_iva);
    }

    public function cantidad_formato_iva()
    {
        return getCantidadFormateada($this->importe * 1.21);
    }

    public function comprobacion_presupuestos(): bool{
        return $this->importe_sin_iva >= 5000;
    }

}