<?php

class Estado
{
    public int $id;
    public string $nombre;
    public string $icono;

    public function __construct($id, $nombre, $icono)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->icono = $icono;
    }
}