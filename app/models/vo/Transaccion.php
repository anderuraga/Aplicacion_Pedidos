<?php
require_once __DIR__ . '/../../helpers/formatos.php';

class Transaccion
{
    public $id;
    public $area_id;
    public $area_nombre;
    public $fecha;
    public $descripcion;
    public $cantidad;

    public function __construct($id, $area_id, $area_nombre, $fecha, $descripcion, $cantidad)
    {
        $this->id = $id;
        $this->area_id = $area_id;
        $this->area_nombre = $area_nombre;
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

    public function cantidad_formato(){
        return getCantidadFormateada($this->cantidad);
    }
}