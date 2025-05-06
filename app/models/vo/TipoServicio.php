<?php

class TipoServicio
{
    public int $id;
    public string $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public static function fromArray(array $row): TipoServicio
    {
        return new TipoServicio(
            (int) $row['tiposervicio_id'],
            $row['tiposervicio_nombre']
        );
    }
}