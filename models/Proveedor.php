<?php namespace soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class Proveedor extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_proveedores';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [        
        'tipo' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Proveedor'"
        ],
        'lugar' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Lugar'"
        ],
    ];
    
    public $hasMany = [
        'servicios' => [
            'soroche\Wayna\Models\Servicio'
        ],
    ];
}
