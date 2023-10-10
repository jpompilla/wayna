<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSorocheWaynaServicioprecioitems extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_servicioprecioitems', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('categoria_id');
            $table->integer('servicio_item_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_servicioprecioitems');
    }
}