<?php
enum tipo_subconcepto
{
    case Fungible;
    case Inventariable;

    public static function fromString(string $value): tipo_subconcepto
    {
        return match($value) {
            'Fungible' => self::Fungible,
            'Inventariable' => self::Inventariable,
            default => throw new InvalidArgumentException("Valor no válido para tipo_subconcepto: $value")
        };
    }
}
class Subconcepto
{
    public int $id;
    public string $nombre;

    public tipo_subconcepto $tipo;

    public function __construct(int $id, string $nombre, string $tipo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = tipo_subconcepto::fromString($tipo);
    }
}