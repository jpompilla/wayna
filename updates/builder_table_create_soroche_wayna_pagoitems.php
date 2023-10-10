<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaPagoitems extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_pagoitems', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('centro_id');
            $table->decimal('monto', 10, 2);
            $table->decimal('acumulado', 10, 2);
            $table->integer('destinable_id');
            $table->string('destinable_type');
            $table->integer('pago_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_pagoitems');
    }
}
