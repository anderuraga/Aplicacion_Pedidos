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

    public static function fromArray(array $row): Departamento
    {
        return new Departamento(
            (int) $row['departamento_id'],
            $row['departamento_nombre']
        );
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->nombre = $data['nombre'];
    }
}