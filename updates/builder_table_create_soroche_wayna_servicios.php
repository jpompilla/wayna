<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;
use Soroche\Wayna\Models\Tipo;

class BuilderTableCreateSorocheWaynaServicios extends Migration
{
    public function up()
    {
        Schema::create('soroche_wayna_servicios', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('negocio_id');
            $table->string('codigo')->nullable();
            $table->string('name')->nullable();
            $table->string('nombre');
            $table->integer('lugar_id')->nullable();
            $table->string('tipo');
            $table->integer('capacidad')->nullable();
            $table->decimal('costo', 10, 2)->nullable();
            $table->text('params')->nullable();
            $table->text('precios')->nullable();
            $table->text('costos')->nullable();
            $table->text('margen')->nullable();
            $table->text('items')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        Tipo::create(['tipo' => 'Lugar', 'nombre' => 'Cusco', 'valor' => '01']);
        Tipo::create(['tipo' => 'Lugar', 'nombre' => 'Cusco > Ciudad Cusco', 'valor' => '0101']);
        Tipo::create(['tipo' => 'Lugar', 'nombre' => 'Cusco > Valle Sagrado', 'valor' => '0102']);
        Tipo::create(['tipo' => 'Lugar', 'nombre' => 'Cusco > Aguas Calientes', 'valor' => '0103']);        
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_servicios');
        Tipo::where('tipo', 'Lugar')->delete();        
    }
}