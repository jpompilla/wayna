<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaServicioitems extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_servicioitems', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('proveedor_id');
            $table->integer('servicio_id');
            $table->increments('id')->unsigned();
            
            $table->integer('dia')->default(1);
            $table->string('hora')->nullable();
            $table->string('nombre');
            $table->integer('item_proveedor_id')->nullable();
            $table->integer('item_servicio_id')->nullable();
            $table->integer('item_id')->nullable();
            
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_servicioitems');
    }
}