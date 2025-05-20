<?php
require_once __DIR__ . '/../../helpers/formatos.php';

class Incidencia
{
    public int $id;
    public string $fecha;
    public string $descripcion;
    public int $estado;
    public string | null $fecha_solucion;

    public function __construct(int $id, string $fecha, string $descripcion, int $estado, string | null $fecha_solucion)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->fecha_solucion = $fecha_solucion;
    }

    public function getFechaVisible()
    {
        $date = new DateTime($this->fecha);
        return $date->format('d/m/Y');
    }
    public function getFechaSolucionVisible()
    {
        $date = new DateTime($this->fecha_solucion);
        return $date->format('d/m/Y');
    }

    public static function fromArray(array $row): Incidencia
    {
        return new Incidencia(
            id: (int) $row['incidencia_id'],
            fecha: $row['incidencia_fecha'],
            descripcion: $row['incidencia_descripcion'],
            estado: $row['incidencia_estado'],
            fecha_solucion: $row['incidencia_fecha_solucion']
        );
    }

}