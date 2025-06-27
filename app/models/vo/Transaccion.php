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
    public string $total;

    public function __construct(int $id, AreaGastos $areaGastos, string $fecha, string $descripcion, string $cantidad, string $total)
    {
        $this->id = $id;
        $this->areaGastos = $areaGastos;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->cantidad = $cantidad;
        $this->total = $total;
    }

    public function getFechaVisible()
    {
        $date = new DateTime($this->fecha);
        return $date->format('d/m/Y');
    }

    public function getOperacion()
    {
        return $this->cantidad > 0 ? 'Ingreso' : 'Gasto';
    }

    public function cantidad_formato()
    {
        return getCantidadFormateada($this->cantidad);
    }

    public function total_formato()
    {
        return getCantidadFormateada($this->total);
    }

    public static function fromArray(array $row): Transaccion
    {
        if (is_null($row['transaccion_id'])) {
            return new Transaccion(
                0,
                new AreaGastos(
                    0,
                    '',
                    new Departamento(
                        0,
                        ''
                    ),
                    '',
                    '',
                    '',
                    ''
                ),
                '',
                '',
                '',
                ''
            );
        } else {
            return new Transaccion(
                id: (int) $row['transaccion_id'],
                areaGastos: AreaGastos::fromArray($row),
                fecha: $row['transaccion_fecha'],
                descripcion: $row['transaccion_descripcion'],
                cantidad: $row['transaccion_cantidad'],
                total: $row['transaccion_total']
            );
        }

    }

}