<?php namespace soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class PagoItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_pagoitems';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'centro' => [
            'Soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Centro de Costo'"
        ],
        'pago' => [
            'Soroche\Wayna\Models\Pago'
        ]
    ];
    
    public $morphTo = [
        'destinable' => []
    ];
    
    public function getNameAttribute(){
        $rpta = "";
        if($this->destinable_type == 'soroche\Wayna\Models\Embajador'){
            $rpta = $this->destinable->codigo;
        }
        if($this->destinable_type == 'soroche\Wayna\Models\Reserva'){
            $rpta = $this->destinable->name;
        }
        if($this->destinable_type == 'soroche\Wayna\Models\Tipo'){
            $rpta = $this->destinable->nombre;
        }
        return $rpta;
    }
    
    public function getDestinableIdOptions($value, $formData){
        $rpta = [];
        if($this->destinable_type == 'soroche\Wayna\Models\Embajador')
            $rpta = Embajador::all()->lists('codigo', 'id');
        if($this->destinable_type == 'soroche\Wayna\Models\Reserva')
            $rpta = Reserva::all()->lists('name', 'id');
        if($this->destinable_type == 'soroche\Wayna\Models\Tipo')
            $rpta = Tipo::where('tipo','Cuenta Bancaria')->get()->lists('nombre', 'id');
        
        return $rpta;
    }
}
