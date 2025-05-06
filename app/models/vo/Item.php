<?php

class Item
{
    public int $id;
    public string $nombre;
    public int $cantidad;

    public function __construct(int $id, string $nombre, int $cantidad = 0)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
    }

    public static function fromArray(array $row): Item
    {
        return new Item(
            (int) $row['item_id'],
            $row['item_nombre'],
            isset($row['item_cantidad']) ? (int)$row['item_cantidad'] : 0
        );
    }
}