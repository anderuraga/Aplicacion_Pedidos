<?php

class Presupuesto
{
    public int $id;
    public string $documento;
    public string $fecha;
    public int $seleccionado;

    public function __construct(int $id, string $documento, string $fecha, int $seleccionado)
    {
        $this->id = $id;
        $this->documento = $documento;
        $this->fecha = $fecha;
        $this->seleccionado = $seleccionado;
    }

    public static function fromArray(array $row): Presupuesto
    {
        return new Presupuesto(
            (int) $row['presupuesto_id'],
            $row['presupuesto_documento'],
            $row['presupuesto_fecha'],
            $row['presupuesto_seleccionado'],
        );
    }

    public function getFechaVisible()
    {
        $date = new DateTime($this->fecha);
        return $date->format('d/m/Y');
    }
}