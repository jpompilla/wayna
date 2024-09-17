<?php namespace Soroche\Wayna\Models;

use Model;
use BackendAuth;

/**
 * Model
 */
class Proveedor extends Model
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
    public $jsonable = ['contactos'];
    
    public $belongsTo = [        
        'tipo' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Negocio'"
        ],
        'condicion' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Condicion Negocio'"
        ],
    ];
    
    public $hasMany = [
        'cuentasbancarias' => [
            'soroche\Wayna\Models\CuentaBancaria',
            'key' => "negocio_id"
        ],
        'servicios' => [
            'soroche\Wayna\Models\Servicio',
            'key' => "negocio_id"
        ],
    ];
    
    
    public $belongsToMany = [
        'clientes' => [
            'soroche\Wayna\Models\Negocio',
            'table' => 'soroche_wayna_proveedores',
            'key'      => 'proveedor_id',
            'otherKey' => 'negocio_id'
        ],
    ];
    
    public function afterCreate()
    {
        $user = BackendAuth::getUser();   
        $this->clientes()->add($user->negocio);
    }
}
