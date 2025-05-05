<?php

class Item
{
    public int $id;
    public string $nombre;
    public int $cantidad;

    public function __construct($id, $nombre, $cantidad)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
    }
}