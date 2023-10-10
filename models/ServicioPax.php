<?php namespace soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class ServicioPax extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_serviciopaxs';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'estado' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Estado Reserva'"
        ],  
    ];
    
    public $belongsToMany = [
        'salidas' => [
            'soroche\Wayna\Models\Salida',
            'table' => 'soroche_wayna_salidas_serviciopaxs',
            'key'      => 'servicio_pax_id',
            'otherKey' => 'salida_id'
        ],
        'reservas' => [
            'soroche\Wayna\Models\Reserva',
            'table' => 'soroche_wayna_reservas_serviciopaxs',
            'key'      => 'servicio_pax_id',
            'otherKey' => 'reserva_id'
        ],
        'paxs' => [
            'soroche\Wayna\Models\Pax',
            'table' => 'soroche_wayna_paxs_serviciopaxs',
            'key'      => 'servicio_pax_id',
            'otherKey' => 'pax_id'
        ]
    ];
}
