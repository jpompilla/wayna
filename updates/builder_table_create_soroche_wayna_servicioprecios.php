<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaServicioprecios extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_servicioprecios', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('proveedor_id')->nullable();
            $table->integer('servicio_id');
            $table->increments('id')->unsigned();
            $table->integer('categoria_id');
            $table->string('codigo')->nullable();
            $table->string('name')->nullable();
            $table->integer('capacidad')->nullable();            
            $table->decimal('costo', 10, 2)->nullable();
            
            $table->text('precios')->nullable();
            $table->boolean('mantener_precios')->default(0);            
            $table->decimal('publicado', 10, 2)->nullable();
            $table->decimal('confidencial', 10, 2)->nullable();            
            $table->decimal('reserva', 10, 2)->nullable();
            $table->decimal('comision', 10, 2)->nullable();
            
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_servicioprecios');
    }
}