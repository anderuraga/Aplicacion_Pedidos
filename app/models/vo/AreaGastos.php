<?php


class AreaGastos
{
    public int $id;
    public string $nombre;
    public int $departamento_id;
    public string $departamento_nombre;

    public string $ingresos;

    public string $gastos;

    public string $diferencia;



    public function __construct($id, $nombre, $departamento_id, $departamento_nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->departamento_id = $departamento_id;
        $this->departamento_nombre = $departamento_nombre;
    }   
}