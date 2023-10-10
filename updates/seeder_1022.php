<?php namespace soroche\Wayna\Updates;

use Seeder;
use Soroche\Wayna\Models\Tipo;

class Seeder1022 extends Seeder
{
    public function run()
    {
        Tipo::create(['nombre' => 'Reserva - Adelanto', 'tipo' => 'Pago']);
        
        Tipo::create(['nombre' => 'Machupicchu101 - Interbank - Dolares', 'tipo' => 'Cuenta Bancaria']);
        Tipo::create(['nombre' => 'Machupicchu101 - Interbank - Soles', 'tipo' => 'Cuenta Bancaria']);
        Tipo::create(['nombre' => 'Machupicchu101 - Efectivo - Dolares', 'tipo' => 'Cuenta Bancaria']);
        Tipo::create(['nombre' => 'Machupicchu101 - Efectivo - Soles', 'tipo' => 'Cuenta Bancaria']);
    }
}