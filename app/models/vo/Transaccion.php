<?php

class Transaccion
{
    public $id;
    public $area_id;
    public $area_nombre;
    public $nombre;
    public $fecha;
    public $descripcion;
    public $cantidad;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key))
                $this->$key = $value;
        }
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
}