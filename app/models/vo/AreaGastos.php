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
    public string $diferencia;

    public function __construct(int $id, string $nombre, Departamento $departamento, string $ingresos, string $gastos, string $diferencia)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->departamento = $departamento;
        $this->ingresos = $ingresos;
        $this->gastos = $gastos;
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
            $row['diferencia']
        );
    }
}