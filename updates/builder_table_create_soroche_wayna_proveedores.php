<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaProveedores extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_proveedores', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('negocio_id');
            $table->integer('proveedor_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_proveedores');
    }
}