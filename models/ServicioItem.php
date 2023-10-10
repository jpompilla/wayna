<?php namespace soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class ServicioItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_servicioitems';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [        
        'servicio' => [
            'soroche\Wayna\Models\Servicio'
        ],
        'item' => [
            'soroche\Wayna\Models\ServicioPrecio'
        ],
        'item_servicio' => [
            'soroche\Wayna\Models\Servicio'
        ],
    ];
    
    public $belongsToMany = [
        /*
        'servicio_precios' => [
            'soroche\Wayna\Models\ServicioPrecio', 
            'table' => 'soroche_wayna_servicioprecioitems',            
        ]
        */
        'categorias' => [
            'soroche\Wayna\Models\Tipo',
            'table' => 'soroche_wayna_servicioprecioitems',
            'otherKey' => 'categoria_id',
            'conditions' => "tipo = 'Categoria'"
        ]
    ];
    
    public function getItemsAttribute(){                
        return ServicioItem::where('servicio_id',$this->item_servicio_id)->get();
    }
    
    public function beforeSave()
    {
        if(!$this->exists){
            $this->proveedor_id = $this->servicio->proveedor_id;
            if($this->item){
                $this->item_proveedor_id = $this->item->proveedor_id;
                $this->item_servicio_id = $this->item->servicio_id;            
            }
        }
    }
    
    
}
