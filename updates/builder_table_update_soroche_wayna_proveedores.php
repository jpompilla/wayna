<?php namespace soroche\Wayna\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSorocheWaynaProveedores extends Migration
{
    public function up()
    {
        Schema::table('soroche_wayna_proveedores', function($table)
        {
            $table->integer('lugar_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('soroche_wayna_proveedores', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
    }
}