<?php namespace soroche\Wayna\Models;

use Model;
use Date;

/**
 * Model
 */
class Salida extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_salidas';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'proveedor' => [
            'soroche\Wayna\Models\Proveedor'
        ],
        'servicio_precio' => [
            'soroche\Wayna\Models\ServicioPrecio'
        ],
        
    ];
    
    public $belongsToMany = [
        'servicio_paxs' => [
            'soroche\Wayna\Models\ServicioPax',
            'table' => 'soroche_wayna_salidas_serviciopaxs',
            'key'      => 'salida_id',
            'otherKey' => 'servicio_pax_id',
            'orderBy' => ['dia','servicio_precio_id']
        ]
    ];
    
    public $hasManyThrough = [
        'paxs' => [
            'soroche\Wayna\Models\Pax',
            //'key'        => 'salida_id',
            'through' => 'soroche\Wayna\Models\Reserva',            
            //'throughKey' => 'reserva_id',
            //'otherKey'   => 'id'
        ],
        
    ];
    
    public function getFechaDateAttribute(){
        return new Date($this->fecha);
    }
    
    public function beforeSave()
    {
        if(!$this->exists){
            $this->proveedor_id = $this->servicio_precio->proveedor_id;
            $this->servicio_id = $this->servicio_precio->servicio_id;
            $this->name = '['.$this->fecha_date->format('Y-m-d')."] ".$this->servicio_precio->name;
        }
        //Session::put('salida_existe?', $this->exists);
    }
}
