<?php namespace Soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class Pax extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

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
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [
        'contacto'
    ];
    
    public $attachOne = [
        'pasaporte_img' => 'System\Models\File'
    ];
    
    public $belongsToMany = [
        'reservas' => [
            'soroche\Wayna\Models\Reserva',
            'table' => 'soroche_wayna_reserva_paxs',
        ],
    ];
    
    public function getFullnameAttribute(){
        return $this->nombres.' '.$this->apellidos;
    }
    public function getTelefonoAttribute(){
        $telefono = '';
        
        foreach($this->contacto as $contacto)
            if(isset($contacto['tipo']) && $contacto['tipo']=='Telefono')
                $telefono = '('.substr($contacto['dato'], 0, 3).') '.substr($contacto['dato'], 3);
        
        return $telefono;
    }
    
    public function getLidercontactoAttribute(){
        $telefono = '';
        
        foreach($this->contacto as $contacto)
            if(isset($contacto['tipo']) && $contacto['tipo']=='Telefono')
                $telefono = $contacto['dato'];
        
        return $telefono.' - '.$this->nombres.' '.$this->apellidos;;
    }

    public function getEdadAttribute(){
        return floor((time()-strtotime($this->fecha_nacimiento))/(60*60*24*365.25));
    }
}
