<?php namespace soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class Pago extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_pagos';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $attachOne = [
        'imagen_comprobante' => 'System\Models\File'
    ];
    
    public $belongsTo = [
        'tipo' => [
            'Soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Pago'"
        ],
        'cuenta' => [
            'Soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Cuenta Bancaria'"
        ]
    ];
    
    public $morphTo = [
        'pagable' => []
    ];
    
    public $hasMany = [
        'items' => [
            'Soroche\Wayna\Models\PagoItem', 'key' => 'pago_id'
        ],
    ];
    
    public function getNombreAttribute(){
        $rpta = "";
        if($this->pagable_type == 'soroche\Wayna\Models\Embajador'){
            $rpta = $this->pagable->codigo;
        }
        if($this->pagable_type == 'soroche\Wayna\Models\Reserva'){
            $rpta = $this->pagable->name;
        }
        return $rpta;
    }
    
    public function getPagableIdOptions($value, $formData){
        $rpta = [];
        if($this->pagable_type == 'soroche\Wayna\Models\Embajador')
            $rpta = Embajador::all()->lists('name', 'id');
        if($this->pagable_type == 'soroche\Wayna\Models\Reserva')
            $rpta = Reserva::all()->lists('name', 'id');
        
        return $rpta;
    }
    
    public function afterCreate()
    {
        if($this->tipo_id == 4){ //Embajador - Inscripcion
            $this->buildEmbajadorInscripcion();
        }
        if($this->tipo_id == 5){ //Embajador - Publicidad
            $this->buildEmbajadorPublicidad();
        }
        if($this->tipo_id == 6){ //Embajador - Egreso Publicidad
            $this->buildEmbajadorEgresoPublicidad();
        }
        if($this->tipo_id == 7){ //Plataforma - Egreso General
            $this->buildPlataformaEgreso();
        }
        if($this->tipo_id == 8){ //Plataforma - Ingreso
            $this->buildPlataformaIngreso();
        }
        if($this->tipo_id == 37){ //Reserva - Adelanto
            $this->buildReservaAdelanto();
        }
    }
    
    private function buildEmbajadorInscripcion(){        
        $this->createPagoItem(
            'soroche\Wayna\Models\Embajador', 
            1, // Plataforma Mapi101
            9, // Caja 
            $this->monto_total);
        $this->createPagoItem(
            'soroche\Wayna\Models\Tipo', 
            $this->cuenta_id, // Cuenta del Pago
            12, // Cuenta
            $this->monto_total);
    }
    private function buildEmbajadorPublicidad(){        
        $this->createPagoItem(
            'soroche\Wayna\Models\Embajador', 
            $this->pagable_id, // Mismo embajador
            10, // Publicidad
            $this->monto_total * 0.9);
        $this->createPagoItem(
            'soroche\Wayna\Models\Embajador', 
            1, // Plataforma Mapi101
            9, // Caja
            $this->monto_total * 0.1);
        $this->createPagoItem(
            'soroche\Wayna\Models\Tipo', 
            $this->cuenta_id, // Cuenta del Pago
            12, // Cuenta
            $this->monto_total);
    }
    private function buildEmbajadorEgresoPublicidad(){        
        $this->createPagoItem(
            'soroche\Wayna\Models\Embajador', 
            $this->pagable_id, // Mismo embajador
            10, // Publicidad
            $this->monto_total*-1);
        $this->createPagoItem(
            'soroche\Wayna\Models\Tipo', 
            $this->cuenta_id, // Cuenta del Pago
            12, // Cuenta
            $this->monto_total*-1);
    }
    private function buildPlataformaEgreso(){        
        $this->createPagoItem(
            'soroche\Wayna\Models\Embajador', 
            1, // Plataforma Mapi101
            9, // caja
            $this->monto_total*-1);
        $this->createPagoItem(
            'soroche\Wayna\Models\Tipo', 
            $this->cuenta_id, // Cuenta del Pago
            12, // Cuenta
            $this->monto_total*-1);
    }
    private function buildPlataformaIngreso(){        
        $this->createPagoItem(
            'soroche\Wayna\Models\Embajador', 
            1, // Plataforma Mapi101
            9, // caja
            $this->monto_total);
        $this->createPagoItem(
            'soroche\Wayna\Models\Tipo', 
            $this->cuenta_id, // Cuenta del Pago
            12, // Cuenta
            $this->monto_total);
    }
    
    private function buildReservaAdelanto(){        
        $this->createPagoItem(
            'soroche\Wayna\Models\Embajador', 
            1, // Plataforma Mapi101
            9, // caja
            $this->monto_total);
        $this->createPagoItem(
            'soroche\Wayna\Models\Tipo', 
            $this->cuenta_id, // Cuenta del Pago
            12, // Cuenta
            $this->monto_total);
    }
    
    private function createPagoItem($type, $type_id, $centro_id, $monto){
        $acum = 0;
        $last = PagoItem::where('destinable_type', $type)
            ->where('destinable_id', $type_id)
            ->where('centro_id', $centro_id)
            ->orderBy('id', 'desc')->first();
        
        if($last)
            $acum = $last->acumulado + $monto;        
        else
            $acum = $monto;
        
        PagoItem::create([
            'pago_id' => $this->id,
            'destinable_type' => $type, 
            'destinable_id' => $type_id,
            'centro_id' => $centro_id,
            'monto' => $monto,
            'acumulado' => $acum
        ]);
        
        if($type == 'soroche\Wayna\Models\Embajador' && $centro_id == 10)
            Embajador::where('id', $type_id)
                ->update(['publicidad' => $acum]);
        if($type == 'soroche\Wayna\Models\Tipo' && $centro_id == 12)
            Tipo::where('id', $type_id)
                ->update(['cuenta' => $acum]);
    }
    
}
