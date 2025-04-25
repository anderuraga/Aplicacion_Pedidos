<?php

class Usuario
{
    public int $id;
    public int $tipo;
    public string $nombre;
    public string $correo;
    public int $departamento_id;
    public string $departamento_nombre;

    public function __construct($id, $tipo, $nombre, $correo, $departamento_id, $departamento_nombre)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->departamento_id = $departamento_id;
        $this->departamento_nombre = $departamento_nombre;
    }
}
