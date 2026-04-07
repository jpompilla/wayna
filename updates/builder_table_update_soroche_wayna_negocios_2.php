<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateSorocheWaynaNegocios2 extends Migration
{
    public function up()
    {
        Schema::table('soroche_wayna_negocios', function($table)
        {
            $table->text('content')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('soroche_wayna_negocios', function($table)
        {
            $table->dropColumn('content');
        });
    }
}
