<?php
require_once __DIR__ . '/Item.php';
class Movimiento
{
    public int $id;
    public Item $item;
    public string $fecha;
    public string $descripcion;
    public int $cantidad;
    public int $total;

    public function __construct(int $id, Item $item, string $fecha, string $descripcion, int $cantidad, int $total=0)
    {
        $this->id = $id;
        $this->item = $item;
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
    
    public static function fromArray(array $row): Movimiento
    {
        return new Movimiento(
            (int)$row['movimiento_id'],
            Item::fromArray($row),
            $row['movimiento_fecha'],
            $row['movimiento_descripcion'],
            (int)$row['movimiento_cantidad'],
            isset($row['movimiento_total']) ? (int)$row['movimiento_total'] : 0
        );
    }
}