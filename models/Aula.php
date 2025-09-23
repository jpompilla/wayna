<?php namespace Soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class Aula extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_aulas';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = ['contenido'];
    
    public $belongsTo = [        
        'curso' => [
            'soroche\Wayna\Models\Curso'
        ],
        'user' => [
            'Backend\Models\User'
        ],
    ];
}
