<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaPagos extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_pagos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('proveedor_id');
            $table->integer('tipo_id');            
            $table->increments('id')->unsigned();
            
            $table->dateTime('fecha');
            $table->integer('pagable_id');
            $table->string('pagable_type');
            
            $table->integer('comprobante_id')->nullable();
            $table->integer('comprobante_codigo')->nullable();
            
            $table->decimal('monto_base', 10, 2);
            $table->decimal('monto_igv', 10, 2);
            $table->decimal('monto_total', 10, 2);
            $table->integer('cuenta_id');
            $table->integer('estado_id');
            
            $table->text('nota')->nullable();            
                        
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_pagos');
    }
}