<?php

class Estado
{

    public static $ESTADO_PENDIENTE = 1;

    public int $id;
    public string $nombre;
    public string $icono;

    public function __construct(int $id, string $nombre, string $icono)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->icono = $icono;
    }

    public static function fromArray(array $row): Estado
    {
        return new Estado(
            (int) $row['estado_id'],
            $row['estado_nombre'],
            $row['icono']
        );
    }
}