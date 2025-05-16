<?php
require_once __DIR__ . '/../../helpers/formatos.php';
require_once __DIR__ . '/Departamento.php';

class AreaGastos
{
    public int $id;
    public string $nombre;
    public Departamento $departamento;

    public string $ingresos;
    public string $gastos;
    public string $gastos_pendiente;
    public string $diferencia;

    public function __construct(int $id, string $nombre, Departamento $departamento, string $ingresos, string $gastos,string $gastos_pendiente, string $diferencia)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->departamento = $departamento;
        $this->ingresos = $ingresos;
        $this->gastos = $gastos;
        $this->gastos_pendiente = $gastos_pendiente;
        $this->diferencia = $diferencia;
    }

    public function ingresos_formato()
    {
        return getCantidadFormateada($this->ingresos);
    }

    public function gastos_formato()
    {
        return getCantidadFormateada($this->gastos);
    }

    public function gastos_pendiente_formato()
    {
        return getCantidadFormateada($this->gastos_pendiente);
    }

    public function diferencia_formato()
    {
        return getCantidadFormateada($this->diferencia);
    }

    public static function fromArray(array $row): AreaGastos
    {
        return new AreaGastos(
            (int) $row['area_id'],
            $row['area_nombre'],
            Departamento::fromArray($row),
            $row['ingresos'],
            $row['gastos'],
            $row['gasto_pendiente'],
            $row['diferencia']
        );
    }
}