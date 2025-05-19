<?php
class Subconcepto
{
    public int $id;
    public string $nombre;


    public function __construct(int $id, string $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public static function fromArray(array $row): Subconcepto
    {
        return new Subconcepto(
            id: (int) $row['subconcepto_id'],
            nombre: $row['subconcepto_nombre'],
        );
    }
}