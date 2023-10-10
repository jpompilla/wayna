<?php namespace soroche\Wayna\Models;

use Model;
use Session;

/**
 * Model
 */
class Pax extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_paxs';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [        
        'tipo_documento' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Tipo de Documento'"
        ],
        'salida' => [
            'soroche\Wayna\Models\Salida'
        ],
    ];
    
    public $attachOne = [
        'imagen_documento' => 'System\Models\File'
    ];
    
    public $belongsToMany = [
        'reservas' => [
            'soroche\Wayna\Models\Reserva',
            'table' => 'soroche_wayna_reserva_paxs'
        ],
        'servicio_paxs' => [
            'soroche\Wayna\Models\ServicioPax',
            'table' => 'soroche_wayna_paxs_serviciopaxs',
            'key'      => 'pax_id',
            'otherKey' => 'servicio_pax_id'
        ]
    ];
    
    public function beforeSave()
    {
        if(!$this->exists){ //Create            
            
        }
        else{
            $this->name = $this->buildName();
        }
        Session::put('pax_existe?', $this->exists);
    }
    
    public function buildName(){
        $rpta = $this->nombres.' '.$this->apellidos;        
        return $rpta;
    }
    
    public function afterSave(){
        if(!Session::get('pax_existe?')){ //Create
        
        }
        else { //Update
            foreach($this->reservas as $r){
                $p = $r->paxs()->first();                
                if($p->id == $this->id){                    
                    $r->name = $r->buildName($p);
                    $r->save();
                }
            }
        }    
        Session::forget('pax_existe?');
    }
}
