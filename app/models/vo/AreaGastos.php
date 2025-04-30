<?php
require_once __DIR__ . '/../../helpers/formatos.php';
require_once __DIR__ . '/Departamento.php';

class AreaGastos
{
    public int $id;
    public string $nombre;
    public Departamento $departamento;

    public string $ingresos;
    public string $gastos;
    public string $diferencia;

    public function __construct($id, $nombre, $departamento_id, $departamento_nombre,$ingresos, $gastos, $diferencia)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->departamento = new Departamento($departamento_id, $departamento_nombre);
        $this->ingresos = $ingresos;
        $this->gastos = $gastos;
        $this->diferencia = $diferencia;
    } 

    public function ingresos_formato(){
        return getCantidadFormateada($this->ingresos);
    }

    public function gastos_formato(){
        return getCantidadFormateada($this->gastos);
    }

    public function diferencia_formato(){
        return getCantidadFormateada($this->diferencia);
    }
}