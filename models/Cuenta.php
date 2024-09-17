<?php namespace Soroche\Wayna\Models;

use Model;
use BackendAuth;

/**
 * Model
 */
class Cuenta extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_cuentas';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];
    
    public $hasMany = [
        'movimientos' => [
            'soroche\Wayna\Models\Movimiento',
            'key' => 'cuenta_codigo', 
            'otherKey' => 'codigo'
        ],
    ];
    
    
    public function movs(){
        $user = BackendAuth::getUser();
        $codigo = $this->codigo;
        return Movimiento::where('cuenta_codigo', 'like', "$codigo%")->get();
    }
}
