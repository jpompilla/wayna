<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateSorocheWaynaNegocios extends Migration
{
    public function up()
    {
        Schema::table('soroche_wayna_negocios', function($table)
        {
            $table->text('evaluaciones')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('soroche_wayna_negocios', function($table)
        {
            $table->dropColumn('evaluaciones');
        });
    }
}
