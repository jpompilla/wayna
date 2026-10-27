<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateSorocheWaynaPaxs extends Migration
{
    public function up()
    {
        Schema::table('soroche_wayna_paxs', function($table)
        {
            $table->string('residencia')->nullable();
            $table->date('pasaporte_vigencia')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('soroche_wayna_paxs', function($table)
        {
            $table->dropColumn('residencia');
            $table->dropColumn('pasaporte_vigencia');
        });
    }
}
