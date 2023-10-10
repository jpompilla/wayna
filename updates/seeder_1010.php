<?php namespace soroche\Wayna\Updates;

use Seeder;
use Soroche\Wayna\Models\Embajador;
use Itegracion\Publis\Models\Embajadores;

class Seeder1010 extends Seeder
{
    public function run()
    {
        $data = Embajadores::orderBy('id')->get();
        foreach ($data as $emb) {
            Embajador::create([
                'nombres' => $emb->nombre,
                'apellidos' => $emb->apellidos,
                'email' => $emb->email,
                'celular' => $emb->celular
            ]);    
        }
    }
}