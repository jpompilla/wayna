<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaServiciopaxs extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_serviciopaxs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('dia')->default(1);
            $table->date('fecha');
            $table->integer('actividad_id')->nullable();
            $table->string('actividad_nombre')->nullable();
            $table->integer('incluye_id')->nullable();
            $table->string('incluye_nombre')->nullable();
            $table->integer('servicio_precio_id');
            $table->string('servicio_precio_nombre');
            $table->integer('nro_paxs')->default(0);
            $table->decimal('costo', 10, 2)->default(0);
            $table->decimal('costo_unitario', 10, 2)->default(0);
            $table->integer('estado_id');
            $table->integer('proveedor_id');
            $table->string('proveedor_nombre');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        Schema::create('soroche_wayna_salidas_serviciopaxs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('salida_id');
            $table->integer('servicio_pax_id');
        });
        
        Schema::create('soroche_wayna_reservas_serviciopaxs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('reserva_id');
            $table->integer('servicio_pax_id');
        });
        
        Schema::create('soroche_wayna_paxs_serviciopaxs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('pax_id');
            $table->integer('servicio_pax_id');
        });
        
        
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_paxs_serviciopaxs');
        Schema::dropIfExists('soroche_wayna_reservas_serviciopaxs');
        Schema::dropIfExists('soroche_wayna_salidas_serviciopaxs');
        
        Schema::dropIfExists('soroche_wayna_serviciopaxs');
    }
}