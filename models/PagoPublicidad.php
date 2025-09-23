<?php namespace Soroche\Wayna\Models;

use Model;
use Soroche\Wayna\Models\Pago;
use BackendAuth;
use Backend\Models\User;
use Soroche\Wayna\Models\Movimiento;


/**
 * Model
 */
class PagoPublicidad extends Pago
{
    public $table = 'soroche_wayna_pagos';
    
    public $hasMany = [
        'movimientos' => [
            'Soroche\Wayna\Models\Movimiento',
            'key' => 'pago_id'
        ]
    ];
    
    public function filterFields($fields, $context = null){
        $user = BackendAuth::getUser();
        $fields->pagable_type->value = 'Backend\Models\User';
        $fields->pagable_type->enabled = false;
        $fields->pagable_id->options = User::all()->lists('fullname', 'id');
        $fields->pagable_id->value = $user->id;
        $fields->asiento_id->options = Asiento::where('negocio_id',$user->negocio_id)->where('tipo','Backend\Models\User')->get()->lists('nombre', 'id');
    }
}
