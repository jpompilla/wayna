<?php namespace Soroche\Wayna\Models;

use Model;
use Soroche\Wayna\Models\Pago;
use BackendAuth;
use Backend\Models\User;
use Soroche\Wayna\Models\Movimiento;


/**
 * Model
 */
class PagoReserva extends Pago
{
    public $table = 'soroche_wayna_pagos';
    
    public $hasMany = [
        'movimientos' => [
            'Soroche\Wayna\Models\Movimiento',
            'key' => 'pago_id'
        ]
    ];
    
    public function filterFields($fields, $context = null){
    }
    
    public function getAsientoIdOptions(){
    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        $rpta = Asiento::where('negocio_id',$user->negocio_id)->where('tipo','soroche\Wayna\Models\Reserva')->get()->lists('nombre', 'id');
        
        return $rpta;
    }
}
