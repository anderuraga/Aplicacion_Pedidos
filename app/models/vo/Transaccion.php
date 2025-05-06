<?php
require_once __DIR__ . '/../../helpers/formatos.php';
require_once __DIR__ . '/AreaGastos.php';

class Transaccion
{
    public int $id;
    public AreaGastos $areaGastos;
    public string $fecha;
    public string $descripcion;
    public string $cantidad;

    public function __construct(int $id, AreaGastos $areaGastos, string $fecha, string $descripcion, string $cantidad)
    {
        $this->id = $id;
        $this->areaGastos = $areaGastos;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->cantidad = $cantidad;
    }

    public function getFechaVisible()
    {
        $date = new DateTime($this->fecha);
        return $date->format('d/m/Y H:i');
    }

    public function getOperacion()
    {
        return $this->cantidad > 0 ? 'Ingreso' : 'Gasto';
    }

    public function cantidad_formato()
    {
        return getCantidadFormateada($this->cantidad);
    }

    public static function fromArray(array $row): Transaccion
    {
        return new Transaccion(
            id: (int) $row['transaccion_id'],
            areaGastos: AreaGastos::fromArray($row),
            fecha: $row['transaccion_fecha'],
            descripcion: $row['transaccion_descripcion'],
            cantidad: $row['transaccion_cantidad']
        );
    }

}