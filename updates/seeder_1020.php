<?php namespace soroche\Wayna\Updates;

use Seeder;
use Soroche\Wayna\Models\Salida;

class Seeder1020 extends Seeder
{
    public function run()
    {
        $s = Salida::create(['fecha' => '2023-08-30', 'servicio_precio_id' => 42]);
        $s = Salida::create(['fecha' => '2023-09-30', 'servicio_precio_id' => 42]);
    }
}