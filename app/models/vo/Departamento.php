<?php

class Departamento
{
    public $id;
    public $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public static function fromArray(array $row): Departamento {
        return new Departamento((int) $row['departamento_id'], $row['departamento_nombre']);
    }
}