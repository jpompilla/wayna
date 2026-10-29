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

        if(!isset($this->reserva))
            return $rpta;
        if(!isset($this->reserva->paxs))
            return $rpta;
        if(count($this->reserva->paxs) == 0)
            return $rpta;            
                
        foreach ($this->reserva->paxs as $pax)
            $rpta[$pax->fullname] = $pax->fullname;
        
        return $rpta;
    }
    public function getDiasDiferenciaAttribute(){        
        return (new \DateTime(date('Y-m-d', strtotime($this->salida))))
            ->diff(new \DateTime(date('Y-m-d', strtotime($this->llegada))))
            ->days;
    }
}
