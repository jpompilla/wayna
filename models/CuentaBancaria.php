<?php namespace Soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class CuentaBancaria extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_cuentasbancarias';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];
    
    public $belongsTo = [     
        'banco' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Banco'"
        ],
        'moneda' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Moneda'"
        ],
    ];
}
