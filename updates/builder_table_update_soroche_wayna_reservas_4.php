<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateSorocheWaynaReservas4 extends Migration
{
    public function up()
    {
        Schema::table('soroche_wayna_reservas', function($table)
        {
            $table->text('obs')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('soroche_wayna_reservas', function($table)
        {
            $table->dropColumn('obs');
        });
    }
}
