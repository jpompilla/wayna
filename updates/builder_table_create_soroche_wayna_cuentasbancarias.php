<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;
use Soroche\Wayna\Models\Tipo;
use Soroche\Wayna\Models\CuentaBancaria;

class BuilderTableCreateSorocheWaynaCuentasbancarias extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_cuentasbancarias', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('nombre');
            $table->integer('banco_id')->nullable();
            $table->integer('moneda_id');
            $table->string('nro_cuenta')->nullable();
            $table->string('cci')->nullable();
            $table->integer('negocio_id');
            
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        $ibk = Tipo::create(['tipo' => 'Banco', 'nombre' => 'Interbank']);
        $bcp = Tipo::create(['tipo' => 'Banco', 'nombre' => 'BCP']);        
        Tipo::create(['tipo' => 'Banco', 'nombre' => 'BBVA']);
        Tipo::create(['tipo' => 'Banco', 'nombre' => 'Scotiabank']);
        
        $moneda = Tipo::create(['tipo' => 'Moneda', 'nombre' => 'Dolares']);
        Tipo::create(['tipo' => 'Moneda', 'nombre' => 'Soles']);
        
        CuentaBancaria::create(['Nombre' => 'Caja Dolares', 'banco_id' => null, 'moneda_id' => $moneda->id, 'nro_cuenta' => 'Efectivo', 'cci' => null, 'negocio_id' => 1 ]);
        CuentaBancaria::create(['Nombre' => 'Interbank Dolares', 'banco_id' => $ibk->id, 'moneda_id' => $moneda->id, 'nro_cuenta' => '420-3006361526', 'cci' => '003-420-003006361526-71', 'negocio_id' => 1 ]);
        CuentaBancaria::create(['Nombre' => 'Interbank Dolares (Jose)', 'banco_id' => $ibk->id, 'moneda_id' => $moneda->id, 'nro_cuenta' => '420-30063614565', 'cci' => '003-420-003006361526-71', 'negocio_id' => 1 ]);
        CuentaBancaria::create(['Nombre' => 'BCP Dolares (Jose)', 'banco_id' => $bcp->id, 'moneda_id' => $moneda->id, 'nro_cuenta' => '420-30063614565', 'cci' => '003-420-003006361526-71', 'negocio_id' => 1 ]);
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_cuentasbancarias');
        Tipo::where('tipo', 'Banco')->delete();
        Tipo::where('tipo', 'Moneda')->delete();
    }
}