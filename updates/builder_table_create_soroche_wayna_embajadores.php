<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaEmbajadores extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_embajadores', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('codigo')->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('celular');
            $table->string('email');
            $table->decimal('publicidad', 10, 2)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_embajadores');
    }
}