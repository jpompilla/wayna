<?php namespace soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class Embajador extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_embajadores';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $morphMany = [
        'pagos' => ['Soroche\Wayna\Models\Pago', 'name' => 'pagable'],
        'movimientos' => ['Soroche\Wayna\Models\PagoItem', 'name' => 'destinable']
    ];
    
    public $hasMany = [
        'reservas' => [
            'soroche\Wayna\Models\Reserva'
        ],
    ];
    
    public function beforeSave(){
        $this->codigo = $this->nombres.' '.$this->apellidos; 
    }
}
