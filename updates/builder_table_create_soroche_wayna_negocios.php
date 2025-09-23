<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;
use Soroche\Wayna\Models\Tipo;
use Soroche\Wayna\Models\Negocio;

class BuilderTableCreateSorocheWaynaNegocios extends Migration
{
    public function up()
    {
        
        Schema::create('soroche_wayna_negocios', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('codigo')->nullable();
            $table->string('name')->nullable();
            $table->string('nombre');
            $table->string('razon_social')->nullable();
            $table->string('ruc')->nullable();
            $table->string('direccion')->nullable();
            $table->integer('condicion_id')->nullable();
            $table->integer('tipo_id');
            $table->text('contactos')->nullable();
            $table->string('categoria')->nullable();
            $table->text('params')->nullable();
            $table->text('terms')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        
        $condition = Tipo::create(['tipo' => 'Condicion Negocio', 'nombre' => 'Certificado']);
        Tipo::create(['tipo' => 'Condicion Negocio', 'nombre' => 'Interno']);
        
        $tipo = Tipo::create(['tipo' => 'Negocio', 'nombre' => 'Agencia de Turismo']);
        Tipo::create(['tipo' => 'Negocio', 'nombre' => 'Transporte']);
        Tipo::create(['tipo' => 'Negocio', 'nombre' => 'Guia de Turismo']);
        Tipo::create(['tipo' => 'Negocio', 'nombre' => 'Restaurante']);
        Tipo::create(['tipo' => 'Negocio', 'nombre' => 'Entradas']);
        Tipo::create(['tipo' => 'Negocio', 'nombre' => 'Hospedaje']);
        
        Negocio::create([
            'nombre' => 'Machupicchu+', 'razon_social' => 'Machupicchu Plus SAC', 'ruc' => '20612964522', 'direccion' => 'Av. Las Flores 203',
            'condicion' => 'No categorizado', 'condicion_id' => $condition->id, 'tipo_id' => $tipo->id, 
            'contactos' => [
                ['valor' => '984206669', 'tipo' => 'Telefono', 'cargo' => 'Gerente', 'nombre' => 'Jose Pompiplla'],
                ['valor' => 'reservas@machupicchu.plus', 'tipo' => 'Correo Electronico', 'cargo' => 'Jefe de Operaciones', 'nombre' => 'Thanu Huaranca']
            ],
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ]
        ]);
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_negocios');
        Tipo::where('tipo', 'Condicion Negocio')->delete();
        Tipo::where('tipo', 'Negocio')->delete();        
    }
}