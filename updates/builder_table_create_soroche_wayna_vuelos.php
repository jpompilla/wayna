<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaVuelos extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_vuelos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('ruta')->nullable();
            $table->string('aerolinea')->nullable();
            $table->string('vuelo')->nullable();
            $table->dateTime('salida')->nullable();
            $table->dateTime('llegada')->nullable();
            $table->string('pasajeros')->nullable();
            $table->integer('reserva_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_vuelos');
    }
}