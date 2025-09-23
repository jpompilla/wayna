<?php namespace Soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class Negocio extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_negocios';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [
        'contactos',
        'params',
        'evaluaciones'
    ];
    
    public $attachOne = [
        'logo' => 'System\Models\File'
    ];
    
    public $belongsTo = [        
        'tipo' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Negocio'"
        ],
        'condicion' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Condicion Negocio'"
        ],
    ];
    
    public $hasMany = [
        'users' => [
            'Backend\Models\User'
        ],
        'cuentasbancarias' => [
            'soroche\Wayna\Models\CuentaBancaria'
        ],
        'cursos' => [
            'soroche\Wayna\Models\Curso'
        ],
        'cuentas' => [
            'soroche\Wayna\Models\Cuenta',
            'order' => 'codigo ASC'
        ],
        'asientos' => [
            'soroche\Wayna\Models\Asiento'
        ],
        'servicios' => [
            'soroche\Wayna\Models\Servicio'
        ],
    ];
    
    public $belongsToMany = [
        'proveedores' => [
            'soroche\Wayna\Models\Negocio',
            'table' => 'soroche_wayna_proveedores',
            'key'      => 'negocio_id',
            'otherKey' => 'proveedor_id'
        ],
    ];
    
    public function getContactoAttribute(){
        $rpta = '';

        if(isset($this->contactos) && count($this->contactos))
        foreach($this->contactos as $contacto)
            if(array_key_exists('reservas', $contacto) && $contacto['reservas'])
                $rpta = $contacto['valor'];
        
        return $rpta;
    }
    
    public function getPlantillaAttribute(){
        $rpta = '';
        
        if(isset($this->contactos) && count($this->contactos))
        foreach($this->contactos as $contacto)
            if($contacto['reservas'])
                $rpta = $contacto['plantilla'];
        
        return $rpta;
    }
}
