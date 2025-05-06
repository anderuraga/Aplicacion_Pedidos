<?php
require_once __DIR__ . '/Item.php';
class Movimiento
{
    public int $id;
    public Item $item;
    public string $fecha;
    public string $descripcion;
    public int $cantidad;

    public function __construct($id, $id_item, $id_nombre, $fecha, $descripcion, $cantidad)
    {
        $this->id = $id;
        $this->item = new Item($id_item,$id_nombre,0);
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->cantidad = $cantidad;
    }

    public function getFechaVisible()
    {
        $date = new DateTime($this->fecha);
        return $date->format('d/m/Y H:i');
    }
}