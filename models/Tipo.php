<?php namespace soroche\Wayna\Models;

use Model;

/**
 * Model
 */
class Tipo extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_tipos';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $morphMany = [
        'movimientos' => ['Soroche\Wayna\Models\PagoItem', 'name' => 'destinable']
    ];
    
    public static function toNew($old_id){
        $rpta = 0;
        if($old_id == 3) // Inscripcion
            $rpta = 4;
        if($old_id == 4) // Publicidad
            $rpta = 5;
        if($old_id == 5) // Jose-BCP
            $rpta = 1;
        if($old_id == 6) // Jose-BCP-Soles
            $rpta = 1;
        if($old_id == 7) // Jose-Interbank
            $rpta = 2;
        if($old_id == 8) // Jose-Interbank-Soles
            $rpta = 2;
        if($old_id == 9) // Juan-BCP
            $rpta = 1;
        if($old_id == 10) // Juan-Interbank
            $rpta = 2;
        if($old_id == 11) // Ingreso-Plataforma
            $rpta = 8;
        if($old_id == 12) // Egreso-Plataforma
            $rpta = 7;
        if($old_id == 13) // Egreso-Publicidad
            $rpta = 6;
        return $rpta;
    }
}
