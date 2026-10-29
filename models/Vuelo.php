<?php namespace Soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class Vuelo extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_vuelos';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];

    public $attachOne = [
        'imagen' => 'System\Models\File'
    ];

    public $belongsTo = [
        'reserva' => [
            'soroche\Wayna\Models\Reserva'
        ]
    ];

    public function getPasajerosOptions(){
        $rpta = [];
        $rpta['Todos'] = 'Todos';

        foreach ($this->reserva->paxs()->get(['nombres', 'apellidos']) as $pax) {
            $nombreCompleto = trim(($pax->nombres ?? '') . ' ' . ($pax->apellidos ?? ''));
            $rpta[$nombreCompleto] = $nombreCompleto;
        }
        
        return $rpta;
    }
}
