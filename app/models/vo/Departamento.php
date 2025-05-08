<?php

class Departamento implements \Serializable
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

    public function serialize(): string
    {
        return serialize([
            'id' => $this->id,
            'nombre' => $this->nombre,
        ]);
    }

    public function unserialize($data): void
    {
        $unserialized = unserialize($data);
        $this->id = $unserialized['id'];
        $this->nombre = $unserialized['nombre'];
    }
}