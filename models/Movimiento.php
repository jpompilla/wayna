<?php namespace Soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class Movimiento extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_movimientos';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $fillable = [
        'pago_id',
        'cuenta_codigo',
        'monto',
        'acumulado'
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];
    
    public $belongsTo = [        
        'cuenta' => [
            'soroche\Wayna\Models\Cuenta'
        ],
    ];
}
