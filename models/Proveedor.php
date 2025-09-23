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
    public $jsonable = [
        'contactos',
        'evaluaciones'
    ];
    
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
    
    /*--------Atributos-----------*/
    
    public function getContactoAttribute(){
        $rpta = '';

        if(isset($this->contactos) && count($this->contactos))
        foreach($this->contactos as $contacto)
            if(array_key_exists('cargo', $contacto) && $contacto['cargo'] == 'Reservas')
                $rpta = $contacto['valor'];
        
        return $rpta;
    }
    public function getEmergenciaAttribute(){
        $rpta = '';

        if(isset($this->contactos) && count($this->contactos))
        foreach($this->contactos as $contacto)
            if(array_key_exists('cargo', $contacto) && $contacto['cargo'] == 'Emergencia')
                $rpta = $contacto['valor'];
        
        return $rpta;
    }
    
    public function getEvaluacionAttribute(){
        $rpta = 'No evaluado';
        $fecha = '01/01/2020';
        
        if(isset($this->evaluaciones))
        foreach($this->evaluaciones as $e => $evaluacion)
            if (strtotime($fecha) < strtotime($evaluacion['fecha'])) {
                $rpta = $evaluacion['puntaje'];
                $fecha = $evaluacion['fecha'];
            }
            
        return $rpta;
    }
    
    /*--------Eventos-----------*/
    
    public function afterCreate()
    {
        $user = BackendAuth::getUser();   
        $this->clientes()->add($user->negocio);
    }
    
    public function beforeSave(){
        //CREATE Y UPDATE
        $evaluaciones = $this->evaluaciones;
        if(isset($evaluaciones)){
            foreach($evaluaciones as $e => $evaluacion)
                if(empty($evaluaciones[$e]['fecha']))
                    $evaluaciones[$e]['puntaje'] = 'No evaluado';
                else{
                    $num = 0;
                    $sum = 0;
                    foreach($evaluacion as $c => $calificacion)
                    if($c <=> 'fecha' && $c <=> 'puntaje'){
                        $num += ($calificacion > 0 ? 1 : 0);
                        $sum += $calificacion;
                    }
                }
            $evaluaciones[$e]['puntaje'] = $this->renderPuntaje($sum, $num);
            
            $this->evaluaciones = $evaluaciones;
        }
    }
    
    /*--------Metodos-----------*/
    
    private function renderPuntaje($sum, $num){
        $rpta = 'No evaluado';
        
        $puntaje = ($num > 0 ? round($sum/$num, 2) : 0);
        if($puntaje > 0)
            $rpta = $puntaje.' - No aprobado';
        if($puntaje >= 2.5)
            $rpta = $puntaje.' - Observado';
        if($puntaje >= 3.5)
            $rpta = $puntaje.' - Aprobado';
        if($puntaje >= 4.5)
            $rpta = $puntaje.' - Excelente';
        
        return $rpta;
    }
}
