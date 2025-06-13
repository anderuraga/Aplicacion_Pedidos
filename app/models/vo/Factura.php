<?php

class Factura
{
    public int $id;
    public string $documento;
    public string $fecha;
    public string $referencia;

    public function __construct(int $id, string $documento, string $fecha, string $referencia)
    {
        $this->id = $id;
        $this->documento = $documento;
        $this->fecha = $fecha;
        $this->referencia = $referencia;
    }

    public static function fromArray(array $row): Factura
    {
        if(is_null($row['factura_id'])){
            return new Factura(
                0,
                '',
                '',
                ''
            );
        }else{
            return new Factura(
            (int) $row['factura_id'],
            $row['factura_documento'],
            $row['factura_fecha'],
            $row['factura_referencia'],
        );
        }

        
    }

    public function getFechaVisible()
    {
        $date = new DateTime($this->fecha);
        return $date->format('d/m/Y');
    }
}