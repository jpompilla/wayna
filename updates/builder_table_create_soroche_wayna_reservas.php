<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaReservas extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_reservas', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('codigo')->nullable();
            $table->string('name')->nullable();
            $table->integer('negocio_id');
            $table->integer('user_id');
            $table->integer('servicio_id');
            $table->date('fecha_inicio')->nullable();
            $table->integer('nro_paxs');
            $table->text('items')->nullable();
            $table->text('vuelos')->nullable();
            
            $table->text('precios')->nullable();
            
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('totalpagos', 10, 2)->nullable();
            $table->decimal('comision', 10, 2)->nullable();
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