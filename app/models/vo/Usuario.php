<?php
require_once __DIR__ .'/Departamento.php';
class Usuario
{
    public int $id;
    public int $tipo;
    public string $nombre;
    public string $correo;
    public Departamento $departamento;

    public function __construct(int $id, int $tipo, string $nombre, string $correo, Departamento $departamento)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->departamento = $departamento;
    }

    public static function fromArray(array $row): Usuario
    {
        return new Usuario(
            id: (int) $row['usuario_id'],
            tipo: (int) $row['usuario_tipo'],
            nombre: $row['usuario_nombre'],
            correo: $row['usuario_correo'],
            departamento: Departamento::fromArray($row)
        );
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'tipo' => $this->tipo,
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'departamento' => $this->departamento,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->tipo = $data['tipo'];
        $this->nombre = $data['nombre'];
        $this->correo = $data['correo'];
        $this->departamento = $data['departamento'];
    }
}
