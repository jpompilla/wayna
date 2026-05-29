<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateSorocheWaynaReservas5 extends Migration
{
    public function up()
    {
        Schema::table('soroche_wayna_reservas', function($table)
        {
            $table->date('fecha_fin')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('soroche_wayna_reservas', function($table)
        {
            $table->dropColumn('fecha_fin');
        });
    }
}