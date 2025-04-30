<?php
require 'Departamento.php';
class Usuario
{
    public int $id;
    public int $tipo;
    public string $nombre;
    public string $correo;

    public Departamento $departamento;

    public function __construct($id, $tipo, $nombre, $correo, $departamento_id, $departamento_nombre)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->departamento = new Departamento($departamento_id, $departamento_nombre);
    }
}
