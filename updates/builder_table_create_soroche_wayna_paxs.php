<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaPaxs extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_paxs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('proveedor_id');
            $table->increments('id')->unsigned();           
            
            $table->text('name')->nullable();
            $table->string('nombres');
            $table->string('apellidos')->nullable();;
            $table->integer('tipo_documento_id')->nullable();;
            $table->string('nro_documento')->nullable();
            
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        Schema::create('soroche_wayna_reserva_paxs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('reserva_id');
            $table->integer('pax_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_reserva_paxs');
        Schema::dropIfExists('soroche_wayna_paxs');
    }
}