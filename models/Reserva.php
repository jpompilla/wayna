<?php namespace soroche\Wayna\Models;

use Model;
use Session;

/**
 * Model
 */
class Reserva extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_reservas';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'proveedor' => [
            'soroche\Wayna\Models\Proveedor'
        ],
        'embajador' => [
            'soroche\Wayna\Models\Embajador'
        ],
        'estado' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Estado Reserva'"
        ],
        'salida' => [
            'soroche\Wayna\Models\Salida'
        ],
    ];
    
    public $belongsToMany = [
        'paxs' => [
            'soroche\Wayna\Models\Pax',
            'table' => 'soroche_wayna_reserva_paxs',
            'orderBy' => ['id']
        ],
        'servicio_paxs' => [
            'soroche\Wayna\Models\ServicioPax',
            'table' => 'soroche_wayna_reservas_serviciopaxs',
            'orderBy' => ['dia','servicio_precio_id']
        ]
    ];
    
    
    public $morphMany = [
        'pagos' => ['Soroche\Wayna\Models\Pago', 'name' => 'pagable'],
    ];
    
    /*
    public $hasMany = [
        'pagos' => [
            'Soroche\Wayna\Models\Pago', 
            'key' => 'pagable_id',
            'conditions' => "pagable_type like '%Reserva%'"
        ],
    ];
    */
    
    public function beforeSave()
    {
        if(!$this->exists){ //Create
            $this->codigo = $this->createCodigo(); 
            $this->name = $this->buildName();
            $this->proveedor_id = 1; //Machupicchu101
            $this->servicio_id = $this->salida->servicio_id;
            $this->servicio_precio_id = $this->salida->servicio_precio_id;
            $this->embajador_id = 11; //Jose Pompilla
            $sp = $this->salida->servicio_precio;
            $this->total = $sp->precios[$this->nro_paxs-1]['confidencial'];
            $this->comision = $sp->precios[$this->nro_paxs-1]['comision_unitario'] * $this->nro_paxs;
            $this->adelanto = $sp->precios[$this->nro_paxs-1]['reserva_unitario'] * $this->nro_paxs;
            $this->saldo = $sp->precios[$this->nro_paxs-1]['confidencial'];
        }
        Session::put('reserva_existe?', $this->exists);
    }
    
    public function createCodigo(){        
        $rpta = '';
            
        $anio = $this->salida->fecha_date->format('Y');
        $last = Reserva::where('codigo', 'like', $anio.'%')->orderBy('codigo','desc')->first();
        if($last)
            $rpta = strval(intval($last->codigo) + 1);
        else
            $rpta = strval(intval($anio)*10000 + 1);
        return $rpta;
    }
    public function buildName($pax = NULL){
        $rpta = $this->codigo;
        if($pax)
            $rpta .= ' - '.$pax->name;
        $rpta .= ' [x'.$this->nro_paxs.']';
        return $rpta;
    }
    
    public function afterSave(){
        if(!Session::get('reserva_existe?')){ //Create
        
            //Cargar Servicios
            
            /*
            $fecha = $this->salida->fecha;
            $categoria_id = $this->salida->servicio_precio->categoria_id;
            $paquete = $this->salida->servicio_precio->servicio;
            
            foreach($paquete->servicio_items as $actividadItem){
                if($paquete->tipo_id == 21 || $actividadItem->categorias->contains($categoria_id)){                    
                    $actividad = $actividadItem->item->servicio;
                    if(count($actividad->servicio_items)){
                        foreach($actividad->servicio_items as $incluyeItem){
                            $sprecio = $incluyeItem->item;
                            $proveedor = $sprecio->servicio->proveedor;
                            
                            $sp = $this->servicio_paxs()->create([
                                'fecha' => $fecha,
                                //'fecha' => date('Y-m-d', strtotime($fecha. ' + '.$actividadItem->dia - 1.' days'));
                                'dia' => $actividadItem->dia,
                                'actividad_id' => $actividadItem->id,
                                'actividad_nombre' => $actividadItem->nombre,
                                'incluye_id' => $incluyeItem->id,
                                'incluye_nombre' => $incluyeItem->nombre,
                                'servicio_precio_id' => $sprecio->id,
                                'servicio_precio_nombre' => $sprecio->codigo,
                                'nro_paxs' => $this->nro_paxs,
                                'costo' => $sprecio->precios[$this->nro_paxs-1]['costo'],
                                'costo_unitario' => $sprecio->precios[$this->nro_paxs-1]['costo_unitario'],
                                'estado_id' => 31, //Estado Pendiente
                                'proveedor_id' => $proveedor->id,
                                'proveedor_nombre' => $proveedor->nombre
                            ]);
                            $this->salida->servicio_paxs()->add($sp);
                        }
                    }
                    else{
                        $sprecio = $actividadItem->item;
                        $proveedor = $sprecio->servicio->proveedor;
                        
                        $sp = $this->servicio_paxs()->create([
                            'fecha' => $fecha,
                                //'fecha' => date('Y-m-d', strtotime($fecha. ' + '.$actividadItem->dia - 1.' days'));
                            'dia' => $actividadItem->dia,
                            'actividad_id' => 0,
                            'actividad_nombre' => 'Acomodación', 
                            'incluye_id' => $actividadItem->id,
                            'incluye_nombre' => $actividadItem->nombre,
                            'servicio_precio_id' => $sprecio->id,
                            'servicio_precio_nombre' => $sprecio->codigo,
                            'nro_paxs' => $this->nro_paxs,
                            'costo' => $sprecio->precios[$this->nro_paxs-1]['costo'],
                            'costo_unitario' => $sprecio->precios[$this->nro_paxs-1]['costo_unitario'],
                            'estado_id' => 31, //Estado Pendiente
                            'proveedor_id' => $proveedor->id,
                            'proveedor_nombre' => $proveedor->nombre
                        ]);
                        $this->salida->servicio_paxs()->add($sp);
                    }
                }
            }
            */
            
            //Cargar Pax
            for ($i = 1; $i <= $this->nro_paxs; $i++) 
                $this->paxs()->create([
                    'nombres' => 'Pax '.$i, 
                    'proveedor_id' => 1 //Machupicchu101
                ]);
        }
        else { //Update
            
        }    
        Session::forget('reserva_existe?');
    }
}
