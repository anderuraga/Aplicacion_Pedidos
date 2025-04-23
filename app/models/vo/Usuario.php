<?php

class Usuario
{
    public int $id;
    public int $tipo;
    public string $nombre;
    public string $correo;
    public int $departamento_id;

    public function __construct($id,$tipo,$nombre,$correo,$departamento_id)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->departamento_id = $departamento_id;
    }
}
