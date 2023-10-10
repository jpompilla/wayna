<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaTipos extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_tipos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('tipo');
            $table->string('nombre');
            $table->string('valor')->nullable();
            $table->decimal('cuenta', 10, 2)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_tipos');
    }
}