<?php

class Item
{
    public int $id;
    public Departamento $departamento;
    public string $nombre;
    public int $cantidad;

    public function __construct(int $id, Departamento $departamento, string $nombre, int $cantidad = 0)
    {
        $this->id = $id;
        $this->departamento = $departamento;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
    }

    public static function fromArray(array $row): Item
    {
        return new Item(
            (int) $row['item_id'],
            Departamento::fromArray($row),
            $row['item_nombre'],
            isset($row['item_cantidad']) ? (int)$row['item_cantidad'] : 0
        );
    }
}