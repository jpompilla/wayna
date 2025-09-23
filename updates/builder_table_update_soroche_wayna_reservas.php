<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateSorocheWaynaReservas extends Migration
{
    public function up()
    {
        Schema::table('soroche_wayna_reservas', function($table)
        {
            $table->string('estado')->nullable();
            $table->text('itinerario')->nullable();
            $table->text('params')->nullable();
            $table->text('adicionales')->nullable();
            $table->text('costos')->nullable();
            $table->text('margen')->nullable();
            $table->integer('servicio_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('soroche_wayna_reservas', function($table)
        {
            $table->dropColumn('estado');
            $table->dropColumn('itinerario');
            $table->dropColumn('params');
            $table->dropColumn('costos');
            $table->dropColumn('margen');
        });
    }
}