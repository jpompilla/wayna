<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateSorocheWaynaReservas3 extends Migration
{
    public function up()
    {
        Schema::table('soroche_wayna_reservas', function($table)
        {
            $table->string('avance')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('soroche_wayna_reservas', function($table)
        {
            $table->dropColumn('avance');
        });
    }
}
