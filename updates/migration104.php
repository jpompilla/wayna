<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class Migration104 extends Migration
{
    public function up()
    {
        Schema::table('backend_users', function($table)
        {
            $table->integer('negocio_id')->nullable();
            $table->string('telefono')->nullable();
        });
    }

    public function down()
    {
        Schema::table('backend_users', function($table)
        {
            $table->dropColumn('negocio_id');
            $table->dropColumn('telefono');
        });
    }
}