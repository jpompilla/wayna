<?php namespace Soroche\Wayna\Models;

use Model;
use BackendAuth;
/**
 * Model
 */
class Curso extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_cursos';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $fillable = [
        'nombre',
        'resumen',
        'contenido',
        'negocio_id',
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = ['contenido'];
    
    public $belongsToMany = [
      'users' => [
          'Backend\Models\User',
          'table' => 'soroche_wayna_aulas',
          'conditions' => "negocio_id = 1" //Aqui mejorar el codigo
      ]
    ];
    
    public function beforeCreate()
    {
        $user = BackendAuth::getUser();   
        $this->negocio_id = $user->negocio_id;
    }
}
