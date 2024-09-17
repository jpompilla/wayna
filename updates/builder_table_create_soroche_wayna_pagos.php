<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;
use Soroche\Wayna\Models\Cuenta;
use Soroche\Wayna\Models\Asiento;

class BuilderTableCreateSorocheWaynaPagos extends Migration
{
    public function up()
    {    
        
        Schema::create('soroche_wayna_pagos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('negocio_id');
            $table->integer('pagable_id');
            $table->string('pagable_type');
            
            $table->integer('asiento_id');
            $table->integer('cuenta_bancaria_id');
            $table->string('operacion_codigo');
            $table->dateTime('operacion_fecha');
            $table->string('comprobante_codigo');
            $table->decimal('monto', 10, 2);
            $table->text('nota')->nullable();
                        
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        Schema::create('soroche_wayna_movimientos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('pago_id');
            
            $table->string('cuenta_codigo');
            $table->decimal('monto', 10, 2);
            $table->decimal('acumulado', 10, 2)->nullable();
                        
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        Schema::create('soroche_wayna_cuentas', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('negocio_id');
            
            $table->string('codigo');
            $table->string('nombre');
                        
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        Schema::create('soroche_wayna_asientos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('negocio_id');
            
            $table->string('nombre');
            $table->text('movimientos');
            $table->text('descripcion')->nullable();
            $table->string('tipo');
                        
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        Cuenta::create(['negocio_id' => 1, 'codigo' => '10',    'nombre' => 'Caja y Bancos']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '1010',  'nombre' => 'Caja y Bancos > Machupicchu+']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '1020',  'nombre' => 'Caja y Bancos > ADTs+']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '40',    'nombre' => 'Proveedores']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '4010',  'nombre' => 'Proveedores > Machupicchu+']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '4020',  'nombre' => 'Proveedores > Comisiones ADTs+']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '42',    'nombre' => 'Publicidad']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '4210',  'nombre' => 'Publicidad > Machupicchu+']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '4220',  'nombre' => 'Publicidad > ADTs+']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '90',    'nombre' => 'Caja Chica']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '9010',  'nombre' => 'Caja Chica > ADTs+']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '9020',  'nombre' => 'Caja Chica > CRMs']);
        
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Ingresos por Inscripcion',
            'tipo' => 'soroche\wayna\models\negocio',
            'movimientos' => [
                ['formato' => '1020%02d%s%04d','constante' => '100'],
                ['formato' => '9010%02d%s%04d','constante' => '100']
            ]
        ]);
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Egreso de Caja Chica',
            'tipo' => 'soroche\wayna\models\negocio',
            'movimientos' => [
                ['formato' => '1010%02d%s%04d','constante' => '-100'],
                ['formato' => '9010%02d%s%04d','constante' => '-100']
            ]
        ]);
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Ingreso Caja Chica',
            'tipo' => 'soroche\wayna\models\negocio',
            'movimientos' => [
                ['formato' => '1010%02d%s%04d','constante' => '100'],
                ['formato' => '9010%02d%s%04d','constante' => '100']
            ]
        ]);
        
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Pago de Publicidad',
            'tipo' => 'Backend\Models\User',
            'movimientos' => [
                ['formato' => '1020%02d%s%04d','constante' => '-100'],
                ['formato' => '4220%02d%s%04d','constante' => '-100']
            ]
        ]);
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Publicidad',
            'tipo' => 'Backend\Models\User',
            'movimientos' => [
                ['formato' => '1020%02d%s%04d','constante' => '100'],
                ['formato' => '4220%02d%s%04d','constante' => '90'],
                ['formato' => '9020%02d%s%04d','constante' => '10']
            ]
        ]);
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_asientos');
        Schema::dropIfExists('soroche_wayna_cuentas');
        Schema::dropIfExists('soroche_wayna_movimientos');
        Schema::dropIfExists('soroche_wayna_pagos');
    }
}