<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaReservas extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_reservas', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('proveedor_id');
            $table->integer('servicio_id');
            $table->integer('servicio_precio_id');
            $table->integer('salida_id');            
            $table->increments('id')->unsigned();
            
            $table->text('codigo')->nullable();
            $table->text('name')->nullable();
            $table->integer('embajador_id');
            $table->integer('estado_id');
            $table->integer('nro_paxs');
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('adelanto', 10, 2)->default(0);
            $table->decimal('comision', 10, 2)->default(0);
            $table->decimal('saldo', 10, 2)->default(0);
            
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_reservas');
    }
}