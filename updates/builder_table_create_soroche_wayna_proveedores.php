<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaProveedores extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_proveedores', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('nombre');
            $table->integer('tipo_id');
        });
        
        Schema::create('soroche_wayna_clienteproveedores', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('cliente_id');
            $table->integer('proveedor_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_clienteproveedores');
        Schema::dropIfExists('soroche_wayna_proveedores');
    }
}