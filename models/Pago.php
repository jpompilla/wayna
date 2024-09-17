<?php namespace Soroche\Wayna\Models;

use Model;
use BackendAuth;
use Backend\Models\User;
use Soroche\Wayna\Models\Movimiento;

/**
 * Model
 */
class Pago extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_pagos';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'monto' => 'required',
        'operacion_fecha' => 'required'
    ];

    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];
    
    public $morphTo = [
        'pagable' => []
    ];
    
    public $attachOne = [
        'operacion_file' => 'System\Models\File'
    ];
    public $attachMany = [
        'comprobante_files' => 'System\Models\File'
    ];
    
    public $belongsTo = [
        'cuenta_bancaria' => [
            'Soroche\Wayna\Models\CuentaBancaria'
        ],
        'asiento' => [
            'Soroche\Wayna\Models\Asiento'
        ]
    ];
    public $hasMany = [
        'movimientos' => [
            'Soroche\Wayna\Models\Movimiento'
        ]
    ];
    
    public function getPublicidadAttribute(){
        $rpta = null;
        
        $rpta = $this->movimientos()->where('cuenta_codigo','like','4220%')->first();
        
        return $rpta;
    }
    
    public function getNameAttribute(){
        $rpta = "";
        if($this->pagable_type == 'Backend\Models\User'){
            $rpta = $this->pagable->fullname;
            $rpta = "(Asesor) $rpta";
        }
        if($this->pagable_type == 'soroche\Wayna\Models\Negocio'){
            $rpta = $this->pagable->nombre;
            $rpta = "(Negocio) $rpta";
        }
        return $rpta;
    }
    
    public function getPagableIdOptions(){
        $rpta = [];
        if($this->pagable_type == 'soroche\Wayna\Models\Negocio'){
            $negocio = BackendAuth::getUser()->negocio;
            $rpta = [$negocio->id=>$negocio->nombre];
        }
        if($this->pagable_type == 'Backend\Models\User')
            $rpta = User::all()->lists('fullname', 'id');    
        if($this->pagable_type == 'soroche\Wayna\Models\Reserva')
            $rpta = [];//Reserva::all()->lists('name', 'id');
        return $rpta;
    }    
    
    public function getAsientoIdOptions(){
    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        $rpta = Asiento::where('negocio_id',$user->negocio_id)->where('tipo',$this->pagable_type)->get()->lists('nombre', 'id');
        
        return $rpta;
    }
    /*
    public function getTipoOptions(){
    
        $rpta = [];
        
        if($this->pagable_type == 'soroche\Wayna\Models\Negocio'){            
            $rpta = [
                "Egreso Caja"=>"Egreso Caja",
                "Ingreso Caja"=>"Ingreso Caja",
                "Ingreso por Inscripciones"=>"Ingreso por Inscripciones",
            ];
        }
        if($this->pagable_type == 'Backend\Models\User'){            
            $rpta = [
                "Publicidad"=>"Publicidad",
                "Egreso Publicidad"=>"Egreso Publicidad",
                "Inscripcion"=>"Inscripcion",
            ];
        }
        if($this->pagable_type == 'soroche\Wayna\Models\Reserva'){            
            $rpta = [
                "Reserva"=>"Reserva",
                "Amortizacion"=>"Amortizacion",
                "Pago a proveedor"=>"Pago a proveedor",
            ];
        }
        
        return $rpta;
    }
    */
    public function beforeCreate()
    {
        $user = BackendAuth::getUser();   
        $this->negocio_id = $user->negocio_id;
    }
    
    public function afterCreate()
    {
        $cuenta = '';
        
        foreach ($this->asiento->movimientos as $mov) {
            if($this->pagable_type == 'soroche\Wayna\Models\Negocio'){            
                $cuenta = 'N';
            }
            if($this->pagable_type == 'Backend\Models\User'){            
                $cuenta = 'A';
            }
            if($this->pagable_type == 'soroche\Wayna\Models\Reserva'){            
                $cuenta = 'R';
            }
            
            $this->createMovimiento(
                sprintf($mov['formato'], $this->cuenta_bancaria_id, $cuenta, $this->pagable_id), 
                $this->monto*intval($mov['constante'])/100
            );
        }
        
        /*
        if($this->tipo == "Ingreso por Inscripciones"){
            $this->createMovimiento('10', $this->monto);
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
        */
    }
    private function createMovimiento($cuenta_codigo, $monto){
        Movimiento::create([
            'pago_id' => $this->id,
            'cuenta_codigo' => $cuenta_codigo,
            'monto' => $monto
        ]);
    }
}
