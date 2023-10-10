<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaServicio extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_servicio', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('proveedor_id');
            $table->increments('id')->unsigned();
            $table->string('codigo')->nullable();
            $table->string('nombre');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('itinerario')->nullable();
            $table->text('incluye')->nullable();
            $table->text('no_incluye')->nullable();
            $table->integer('tipo_id');
            $table->integer('lugar_inicio_id')->nullable();
            $table->integer('lugar_fin_id')->nullable();            
            $table->integer('capacidad')->nullable();            
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_servicio');
    }
}