<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;
use Soroche\Wayna\Models\Curso;

class BuilderTableCreateSorocheWaynaCursos extends Migration
{
    public function up()
    {
        
        Schema::create('soroche_wayna_cursos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('nombre');
            $table->text('resumen')->nullable();
            $table->text('contenido');
            $table->integer('negocio_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        Schema::create('soroche_wayna_aulas', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('curso_id');
            $table->text('contenido')->nullable();
            $table->integer('user_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
        /*
        Curso::create([
            'nombre'=>'Programa ADT+',
            'resumen'=>'Entrenamiento para nuevos Agentes Digitales de Turismo para Machupicchu+',
            'contenido'=>[
                'unidad' => 'Unidad 1: Introduccion',
                'actividades'=> [
                    ['titulo'=>'Certificacion ADT+ 2024', 'video'=>'GeSVWH_aHLc'],
                    ['titulo'=>'Construye tu jubilación con el Plan de Carrera ADT+', 'video'=>'2tRRYMzJItI'],
                ],
            ], 
            'negocio_id' => 1,
        ]);
        */
    }
    
    public function down()
    {
        Schema::dropIfExists('soroche_wayna_aulas');
        Schema::dropIfExists('soroche_wayna_cursos');
    }
}