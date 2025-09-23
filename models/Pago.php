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
        if($this->pagable_type == 'Soroche\Wayna\Models\Negocio'){
            $rpta = $this->pagable->nombre;
            $rpta = "(Negocio) $rpta";
        }
        return $rpta;
    }
    
    public function getPagableIdOptions(){
        $rpta = [];
        if($this->pagable_type == 'Soroche\Wayna\Models\Negocio'){
            $negocio = BackendAuth::getUser()->negocio;
            $rpta = [$negocio->id=>$negocio->nombre];
        }
        if($this->pagable_type == 'Backend\Models\User')
            $rpta = User::all()->lists('fullname', 'id');    
        if($this->pagable_type == 'Soroche\Wayna\Models\Reserva')
            $rpta = Reserva::all()->lists('codigo', 'id');
        return $rpta;
    }    
    
    public function getAsientoIdOptions(){
    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        $rpta = Asiento::where('negocio_id',$user->negocio_id)->where('tipo',$this->pagable_type)->get()->lists('nombre', 'id');
        
        return $rpta;
    }

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();   
        $this->negocio_id = $user->negocio_id;
    }
    
    public function afterCreate()
    {
        $cuenta = '';
        $monto = 0;
        $user = BackendAuth::getUser();
        
        foreach ($this->asiento->movimientos as $mov) {
            if($this->pagable_type == 'Soroche\Wayna\Models\Negocio'){            
                $cuenta = $mov['formato'];
                $cuenta = str_replace("[banco]", sprintf('%02d',$this->cuenta_bancaria_id), $cuenta);
                $cuenta = str_replace("[negocio]", sprintf('R%04d',$this->pagable_id), $cuenta);
                $monto = $this->monto*intval($mov['porcentaje'])/100;
            }
            if($this->pagable_type == 'Backend\Models\User'){            
                $cuenta = $mov['formato'];
                $cuenta = str_replace("[banco]", sprintf('%02d',$this->cuenta_bancaria_id), $cuenta);
                $cuenta = str_replace("[adt]", sprintf('R%04d',$this->pagable_id), $cuenta);
                $monto = $this->monto*intval($mov['porcentaje'])/100;
            }
            if($this->pagable_type == 'Soroche\Wayna\Models\Reserva'){            
                $cuenta = $mov['formato'];
                $cuenta = str_replace("[banco]", sprintf('%02d',$this->cuenta_bancaria_id), $cuenta);
                $cuenta = str_replace("[reserva]", sprintf('R%04d',$this->pagable_id), $cuenta);
                $cuenta = str_replace("[adt]", sprintf('A%04d',$user->id), $cuenta);
                if($mov['porcentaje'] == 0)
                    $monto = str_replace("[comision]", 150, $mov['constante']); //Aqui poner comision de reserva
                else
                    $monto = $this->monto*intval($mov['porcentaje'])/100;
            }
            
            $this->createMovimiento($cuenta, $monto);
        }
    }
    
    private function createMovimiento($cuenta_codigo, $monto){
        Movimiento::create([
            'pago_id' => $this->id,
            'cuenta_codigo' => $cuenta_codigo,
            'monto' => $monto
        ]);
    }
}
