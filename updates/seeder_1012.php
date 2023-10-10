<?php namespace soroche\Wayna\Updates;

use Seeder;
use Soroche\Wayna\Models\Pago;
use Soroche\Wayna\Models\Tipo;
use Itegracion\Publis\Models\Pagos;

class Seeder1012 extends Seeder
{
    public function run()
    {
        $data = Pagos::orderBy('id')->take(50)->get();
        foreach ($data as $p) {
            Pago::create([
                'proveedor_id' => 1,
                'fecha' => $p->fecha,
                'monto_base' => abs($p->monto),
                'monto_igv' => 0,
                'monto_total' => abs($p->monto),
                'comprobante_id' => 37, //Recibo de Ingreso
                'estado_id' => 46,
                'nota' => $p->nota,
                'tipo_id' => Tipo::toNew($p->tipo_id),
                'cuenta_id' => Tipo::toNew($p->cuenta_id),
                'pagable_type' => 'soroche\Wayna\Models\Embajador',
                'pagable_id' => $p->embajador_id
            ]);    
        }
    }
}