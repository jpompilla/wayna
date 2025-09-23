<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaPaxs extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_paxs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('pasaporte_nro')->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('nacionalidad')->nullable();
            $table->boolean('lider');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('acomodacion')->nullable();
            $table->text('contacto')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        Schema::create('soroche_wayna_reserva_paxs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('reserva_id');
            $table->integer('pax_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_reserva_paxs');
        Schema::dropIfExists('soroche_wayna_paxs');
    }
}