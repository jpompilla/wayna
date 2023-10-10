<?php namespace soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class ServicioPrecio extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_servicioprecios';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $jsonable = [
        'precios'
    ];
    
    public $belongsTo = [        
        'servicio' => [
            'soroche\Wayna\Models\Servicio'
        ],
        'categoria' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Categoria'"
        ],
    ];
    /*
    public $belongsToMany = [
        'servicio_items' => [
            'soroche\Wayna\Models\ServicioItem', 
            'table' => 'soroche_wayna_servicioprecioitems',
            'key' => 'categoria_id',
        ]
    ];    
    */
    public function getTipoAttribute(){        
        return $this->servicio ? $this->servicio->tipo->nombre : null;
    }
    
    public function scopeServicioProveedor($query)
    {
        return $query->whereHas('servicio', function ($q) {
            $q->where('tipo_id', 22); //Servicio de Proveedor
        });
    }
    public function scopeActividades($query)
    {
        return $query->whereHas('servicio', function ($q) {
            $q->whereIn('tipo_id', [21,22]); //Actvidades y Servicio de Proveedor
        });
    }
    public function scopePaquetes($query)
    {
        return $query->whereHas('servicio', function ($q) {
            $q->whereIn('tipo_id', [20,21]); //Actvidades y Servicio de Proveedor
        });
    }
}
