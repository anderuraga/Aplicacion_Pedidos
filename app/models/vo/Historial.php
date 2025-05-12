<?php

class Historial
{
    public int $id;
    public string $fecha;
    public string $comentario;

    public function __construct(int $id, string $fecha, string $comentario)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->comentario = $comentario;
    }

    public static function fromArray(array $row): Historial
    {
        return new Historial(
            (int) $row['historial_id'],
            $row['historial_fecha'],
            $row['historial_comentario']
        );
    }

    public function getFechaVisible()
    {
        $date = new DateTime($this->fecha);
        return $date->format('d/m/Y');
    }

    public function getHoraVisible()
    {
        $date = new DateTime($this->fecha);
        return $date->format('H:i');
    }
}