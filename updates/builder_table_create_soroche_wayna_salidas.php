<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaSalidas extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_salidas', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('proveedor_id');
            $table->integer('servicio_id');
            $table->integer('servicio_precio_id');
            $table->increments('id')->unsigned();
            
            $table->text('codigo')->nullable();
            $table->text('name')->nullable();
            $table->date('fecha');
            $table->integer('nro_paxs')->default(0);
            
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_salidas');
    }
}