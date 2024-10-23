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
        Cuenta::create(['negocio_id' => 1, 'codigo' => '12',    'nombre' => 'Clientes']);
        Cuenta::create(['negocio_id' => 1, 'codigo' => '1210',  'nombre' => 'Clientes > Machupicchu+']);
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
            'tipo' => 'Soroche\Wayna\Models\Negocio',
            'movimientos' => [
                ['formato' => '1020[banco][negocio]','porcentaje' => '100', 'constante' => '0'],
                ['formato' => '901000[negocio]','porcentaje' => '100', 'constante' => '0']
            ]
        ]);
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Egreso de Caja Chica',
            'tipo' => 'Soroche\Wayna\Models\Negocio',
            'movimientos' => [
                ['formato' => '1010[banco][negocio]','porcentaje' => '-100','constante' => '0'],
                ['formato' => '901000[negocio]','porcentaje' => '-100','constante' => '0']
            ]
        ]);
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Ingreso Caja Chica',
            'tipo' => 'Soroche\Wayna\Models\Negocio',
            'movimientos' => [
                ['formato' => '1010[banco][negocio]','porcentaje' => '100','constante' => '0'],
                ['formato' => '901000[negocio]','porcentaje' => '100','constante' => '0']
            ]
        ]);
        
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Pago de Publicidad',
            'tipo' => 'Backend\Models\User',
            'movimientos' => [
                ['formato' => '1020[banco][adt]','porcentaje' => '-100','constante' => '0'],
                ['formato' => '422000[adt]','porcentaje' => '-100','constante' => '0']
            ]
        ]);
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Publicidad',
            'tipo' => 'Backend\Models\User',
            'movimientos' => [
                ['formato' => '1020[banco][adt]','porcentaje' => '100','constante' => '0'],
                ['formato' => '422000[adt]','porcentaje' => '90','constante' => '0'],
                ['formato' => '902000[adt]','porcentaje' => '10','constante' => '0']
            ]
        ]);
        
        Asiento::create(['negocio_id' => 1, 
            'nombre' => 'Pago de Reserva (Adelanto)',
            'tipo' => 'Soroche\Wayna\Models\Reserva',
            'movimientos' => [
                ['formato' => '1010[banco][reserva]','porcentaje' => '100','constante' => ''],
                ['formato' => '121000[reserva]','porcentaje' => '100','constante' => ''],
                //['formato' => '1010[banco][reserva]','porcentaje' => '-5','constante' => ''],
                ['formato' => '121000[reserva]','porcentaje' => '-5','constante' => ''],
                ['formato' => '401000Q0001','porcentaje' => '5','constante' => ''],
                ['formato' => '121000[reserva]','porcentaje' => '0','constante' => '-[comision]'],
                ['formato' => '402000[adt]','porcentaje' => '0','constante' => '[comision]'],
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