<?php namespace soroche\Wayna\Models;

use Model;
use Session;

/**
 * Model
 */
class Servicio extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_servicio';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    protected $jsonable = [
        'itinerario',
        'incluye',
        'no_incluye'
    ];
    
    public $belongsTo = [
        'proveedor' => [
            'soroche\Wayna\Models\Proveedor'
        ],
        'tipo' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Servicio'"
        ],
        'lugar_inicio' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Lugar'"
        ],
        'lugar_fin' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Lugar'"
        ],
        
    ];
    
    public $hasMany = [
        'servicio_precios' => [
            'soroche\Wayna\Models\ServicioPrecio'
        ],
        'servicio_items' => [
            'soroche\Wayna\Models\ServicioItem',
            'orderBy' => 'dia asc',
        ]
    ];
    
    public $belongsToMany = [
        'categorias' => [
            'soroche\Wayna\Models\Tipo',
            'table' => 'soroche_wayna_servicioprecios',
            'otherKey' => 'categoria_id',
            'conditions' => "tipo = 'Categoria'"
        ]
    ];
    
    public $hasOne = [
        'servicio_precio' => [
            'soroche\Wayna\Models\ServicioPrecio',
            'conditions' => "categoria_id = 26"
        ],
        
        'servicio_2e' => [
            'soroche\Wayna\Models\ServicioPrecio',
            'conditions' => "categoria_id = 27"
        ],        
        'servicio_3e' => [
            'soroche\Wayna\Models\ServicioPrecio',
            'conditions' => "categoria_id = 28"
        ],
        'servicio_4e' => [
            'soroche\Wayna\Models\ServicioPrecio',
            'conditions' => "categoria_id = 29"
        ],
        'servicio_5e' => [
            'soroche\Wayna\Models\ServicioPrecio',
            'conditions' => "categoria_id = 30"
        ],
    ];
    
    public $attachOne = [
        'poster' => 'System\Models\File',
        'thumbnail' => 'System\Models\File',
    ];
    
    public $attachMany = [
        'gallery' => 'System\Models\File'
    ];
    
    /* ---- Inicio Hack: Precios -------*/
    public function getMantenerPreciosAttribute(){        
        return $this->servicio_precio ? $this->servicio_precio->mantener_precios : null;
    }    
    public function setMantenerPreciosAttribute($value){
        if($this->servicio_precio)
            $this->servicio_precio->mantener_precios = $value;
    }
    
    public function getCostoAttribute(){        
        return $this->servicio_precio ? $this->servicio_precio->costo : null;
    }    
    public function setCostoAttribute($value){
        if(!$this->servicio_precio)
            $this->servicio_precio = new ServicioPrecio();
        $this->servicio_precio->costo = $value;
    }
    public function getConfidencialAttribute(){        
        return $this->servicio_precio ? $this->servicio_precio->confidencial : null;
    }    
    public function setConfidencialAttribute($value){
        if($this->servicio_precio)
            $this->servicio_precio->confidencial = $value;
    }
    public function getReservaAttribute(){        
        return $this->servicio_precio ? $this->servicio_precio->reserva : null;
    }    
    public function setReservaAttribute($value){
        if($this->servicio_precio)
            $this->servicio_precio->reserva = $value;
    }
    public function getComisionAttribute(){        
        return $this->servicio_precio ? $this->servicio_precio->comision : null;
    }    
    public function setComisionAttribute($value){
        if($this->servicio_precio)
            $this->servicio_precio->comision = $value;
    }
    public function getPublicadoAttribute(){        
        return $this->servicio_precio ? $this->servicio_precio->publicado : null;
    }    
    public function setPublicadoAttribute($value){
        if($this->servicio_precio)
            $this->servicio_precio->publicado = $value;
    }
    
    public function getPreciosAttribute(){        
        return $this->servicio_precio ? $this->servicio_precio->precios : null;
    }    
    public function setPreciosAttribute($value){
        if($this->servicio_precio){
            $this->servicio_precio->precios = $value;
            $this->servicio_precio->save();
        }
    }
    
    public function getMantenerPrecios2Attribute(){        
        return $this->servicio_2e ? $this->servicio_2e->mantener_precios : null;
    }    
    public function setMantenerPrecios2Attribute($value){
        if($this->servicio_2e)
            $this->servicio_2e->mantener_precios = $value;
    }
    public function getCosto2Attribute(){        
        return $this->servicio_2e ? $this->servicio_2e->costo : null;
    }    
    public function setCosto2Attribute($value){
        if(!$this->servicio_2e)
            $this->servicio_2e = new ServicioPrecio();
        $this->servicio_2e->costo = $value;
    }
    public function getConfidencial2Attribute(){        
        return $this->servicio_2e ? $this->servicio_2e->confidencial : null;
    }    
    public function setConfidencial2Attribute($value){
        if($this->servicio_2e)
            $this->servicio_2e->confidencial = $value;
    }
    public function getReserva2Attribute(){        
        return $this->servicio_2e ? $this->servicio_2e->reserva : null;
    }    
    public function setReserva2Attribute($value){
        if($this->servicio_2e)
            $this->servicio_2e->reserva = $value;
    }
    public function getComision2Attribute(){        
        return $this->servicio_2e ? $this->servicio_2e->comision : null;
    }    
    public function setComision2Attribute($value){
        if($this->servicio_2e)
            $this->servicio_2e->comision = $value;
    }
    public function getPublicado2Attribute(){        
        return $this->servicio_2e ? $this->servicio_2e->publicado : null;
    }    
    public function setPublicado2Attribute($value){
        if($this->servicio_2e)
            $this->servicio_2e->publicado = $value;
    }
    public function getPrecios2Attribute(){        
        return $this->servicio_2e ? $this->servicio_2e->precios : null;
    }    
    public function setPrecios2Attribute($value){
        if($this->servicio_2e){
            $this->servicio_2e->precios = $value;
            $this->servicio_2e->save();
        }
    }
    
    public function getMantenerPrecios3Attribute(){        
        return $this->servicio_3e ? $this->servicio_3e->mantener_precios : null;
    }    
    public function setMantenerPrecios3Attribute($value){
        if($this->servicio_3e)
            $this->servicio_3e->mantener_precios = $value;
    }
    public function getCosto3Attribute(){        
        return $this->servicio_3e ? $this->servicio_3e->costo : null;
    }    
    public function setCosto3Attribute($value){
        if(!$this->servicio_3e)
            $this->servicio_3e = new ServicioPrecio();
        $this->servicio_3e->costo = $value;
    }
    public function getConfidencial3Attribute(){        
        return $this->servicio_3e ? $this->servicio_3e->confidencial : null;
    }    
    public function setConfidencial3Attribute($value){
        if($this->servicio_3e)
            $this->servicio_3e->confidencial = $value;
    }
    public function getReserva3Attribute(){        
        return $this->servicio_3e ? $this->servicio_3e->reserva : null;
    }    
    public function setReserva3Attribute($value){
        if($this->servicio_3e)
            $this->servicio_3e->reserva = $value;
    }
    public function getComision3Attribute(){        
        return $this->servicio_3e ? $this->servicio_3e->comision : null;
    }    
    public function setComision3Attribute($value){
        if($this->servicio_3e)
            $this->servicio_3e->comision = $value;
    }
    public function getPublicado3Attribute(){        
        return $this->servicio_3e ? $this->servicio_3e->publicado : null;
    }    
    public function setPublicado3Attribute($value){
        if($this->servicio_3e)
            $this->servicio_3e->publicado = $value;
    }
    public function getPrecios3Attribute(){        
        return $this->servicio_3e ? $this->servicio_3e->precios : null;
    }    
    public function setPrecios3Attribute($value){
        if($this->servicio_3e){
            $this->servicio_3e->precios = $value;
            $this->servicio_3e->save();
        }
    }
    
    public function getMantenerPrecios4Attribute(){        
        return $this->servicio_4e ? $this->servicio_4e->mantener_precios : null;
    }    
    public function setMantenerPrecios4Attribute($value){
        if($this->servicio_4e)
            $this->servicio_4e->mantener_precios = $value;
    }
    public function getCosto4Attribute(){        
        return $this->servicio_4e ? $this->servicio_4e->costo : null;
    }    
    public function setCosto4Attribute($value){
        if(!$this->servicio_4e)
            $this->servicio_4e = new ServicioPrecio();
        $this->servicio_4e->costo = $value;
    }
    public function getConfidencial4Attribute(){        
        return $this->servicio_4e ? $this->servicio_4e->confidencial : null;
    }    
    public function setConfidencial4Attribute($value){
        if($this->servicio_4e)
            $this->servicio_4e->confidencial = $value;
    }
    public function getReserva4Attribute(){        
        return $this->servicio_4e ? $this->servicio_4e->reserva : null;
    }    
    public function setReserva4Attribute($value){
        if($this->servicio_4e)
            $this->servicio_4e->reserva = $value;
    }
    public function getComision4Attribute(){        
        return $this->servicio_4e ? $this->servicio_4e->comision : null;
    }    
    public function setComision4Attribute($value){
        if($this->servicio_4e)
            $this->servicio_4e->comision = $value;
    }
    public function getPublicado4Attribute(){        
        return $this->servicio_4e ? $this->servicio_4e->publicado : null;
    }    
    public function setPublicado4Attribute($value){
        if($this->servicio_4e)
            $this->servicio_4e->publicado = $value;
    }
    public function getPrecios4Attribute(){        
        return $this->servicio_4e ? $this->servicio_4e->precios : null;
    }    
    public function setPrecios4Attribute($value){
        if($this->servicio_4e){
            $this->servicio_4e->precios = $value;
            $this->servicio_4e->save();
        }
    }
    
    public function getMantenerPrecios5Attribute(){        
        return $this->servicio_5e ? $this->servicio_5e->mantener_precios : null;
    }    
    public function setMantenerPrecios5Attribute($value){
        if($this->servicio_5e)
            $this->servicio_5e->mantener_precios = $value;
    }
    public function getCosto5Attribute(){        
        return $this->servicio_5e ? $this->servicio_5e->costo : null;
    }    
    public function setCosto5Attribute($value){
        if(!$this->servicio_5e)
            $this->servicio_5e = new ServicioPrecio();
        $this->servicio_5e->costo = $value;
    }
    public function getConfidencial5Attribute(){        
        return $this->servicio_5e ? $this->servicio_5e->confidencial : null;
    }    
    public function setConfidencial5Attribute($value){
        if($this->servicio_5e)
            $this->servicio_5e->confidencial = $value;
    }
    public function getReserva5Attribute(){        
        return $this->servicio_5e ? $this->servicio_5e->reserva : null;
    }    
    public function setReserva5Attribute($value){
        if($this->servicio_5e)
            $this->servicio_5e->reserva = $value;
    }
    public function getComision5Attribute(){        
        return $this->servicio_5e ? $this->servicio_5e->comision : null;
    }    
    public function setComision5Attribute($value){
        if($this->servicio_5e)
            $this->servicio_5e->comision = $value;
    }
    public function getPublicado5Attribute(){        
        return $this->servicio_5e ? $this->servicio_5e->publicado : null;
    }    
    public function setPublicado5Attribute($value){
        if($this->servicio_5e)
            $this->servicio_5e->publicado = $value;
    }
    public function getPrecios5Attribute(){        
        return $this->servicio_5e ? $this->servicio_5e->precios : null;
    }    
    public function setPrecios5Attribute($value){
        if($this->servicio_5e){
            $this->servicio_5e->precios = $value;
            $this->servicio_5e->save();
        }
    }    
    /* ---- Fin Hack: Precios -------*/
    
    public function filterFields($fields, $context = null)
    {
        if($this->exists and $this->tipo_id == 20){ //Paquete
            if(!$this->categorias->contains(26)){//Estandar
                $fields->precios->hidden = true;
                $fields->confidencial->hidden = true;
                $fields->reserva->hidden = true;
                $fields->comision->hidden = true;
                $fields->publicado->hidden = true;
                $fields->mantener_precios->hidden = true;
            }
            if(!$this->categorias->contains(27)){//2 Estrekkas
                $fields->precios2->hidden = true;
                $fields->confidencial2->hidden = true;
                $fields->reserva2->hidden = true;
                $fields->comision2->hidden = true;
                $fields->publicado2->hidden = true;
                $fields->mantener_precios2->hidden = true;
            }
            if(!$this->categorias->contains(28)){//3 Estrekkas
                $fields->precios3->hidden = true;
                $fields->confidencial3->hidden = true;
                $fields->reserva3->hidden = true;
                $fields->comision3->hidden = true;
                $fields->publicado3->hidden = true;
                $fields->mantener_precios3->hidden = true;
            }
            if(!$this->categorias->contains(29)){//4 Estrekkas
                $fields->precios4->hidden = true;
                $fields->confidencial4->hidden = true;
                $fields->reserva4->hidden = true;
                $fields->comision4->hidden = true;
                $fields->publicado4->hidden = true;
                $fields->mantener_precios4->hidden = true;
            }
            if(!$this->categorias->contains(30)){//5 Estrekkas
                $fields->precios5->hidden = true;
                $fields->confidencial5->hidden = true;
                $fields->reserva5->hidden = true;
                $fields->comision5->hidden = true;
                $fields->publicado5->hidden = true;
                $fields->mantener_precios5->hidden = true;
            }
        }
    }
    
    //public function getItems($servicio = NULL){
    public function getItems(){
        $rpta = [];
        //$s =  ($servicio ? $servicio : $this);
        foreach($this->servicio_items as $item){
            if($item->item_servicio->tipo_id == 21) //Actividad (Tour)
                $rpta[$item->dia]['actividad'] = $item;
            if($item->item_servicio->tipo_id == 22) //Servicio Proveedor
                $rpta[$item->dia]['hoteles'][] = $item;
        }
         
         return $rpta;
    }    
    
    public function beforeSave()
    {
        if(!$this->exists){
            
            if($this->tipo_id == 22){ //Servicio Proveedor
                $this->name = $this->proveedor->nombre." - ".$this->nombre;
                $this->servicio_precio->proveedor_id = 1; 
                $this->servicio_precio->categoria_id = 26; // Estandar
            }
            
            if($this->tipo_id == 21){ //Actividad (Tour)
                $this->proveedor_id = 1;
                $this->name = $this->proveedor->nombre." - ".$this->nombre;
                $this->name .= ' ['.$this->lugar_inicio->nombre.' - '.$this->lugar_fin->nombre.']';
            }
            if($this->tipo_id == 20){ //Paquete
                $this->proveedor_id = 1;
                $this->name = $this->proveedor->nombre." - ".$this->nombre;
            }
        }
        Session::put('servicio_existe?', $this->exists);
    }
    
    public function afterSave(){
        if(!Session::get('servicio_existe?')){ //Create
            if($this->tipo_id == 22){ //Servicio de proveedor            
                $precios = [];
                $rpta = post();
                for ($i = 1; $i <= 10; $i++) {
                    $cantidad = intdiv($i-1, $this->capacidad) + 1;
                    $this->reserva = $this->confidencial;
                    $precios[] = [
                        "nro_pax" => $i,
                        "costo" => $cantidad * $this->costo,
                        "costo_unitario" => round(($cantidad * $this->costo) / $i, 2),
                        "confidencial" => $cantidad * $this->confidencial,
                        "confidencial_unitario" => round(($cantidad * $this->confidencial) / $i, 2),
                        "reserva_unitario" => round(($cantidad * $this->reserva) / $i, 2),
                        "comision_unitario" => round(($cantidad * $this->comision) / $i, 2), 
                        "publicado_unitario" => round(($cantidad * $this->publicado) / $i, 2),
                    ];
                }
                
                $this->servicio_precio->name = $this->proveedor->nombre . " - " . $this->nombre;
                $this->servicio_precio->proveedor_id = $this->proveedor_id;
                $this->servicio_precio->precios = $precios;
                $this->servicio_precio->save();
            }
            if($this->tipo_id == 21){ //Actividad (Tour)
                
                ServicioPrecio::create([
                    'categoria_id' => 26, // Estandar
                    'name' => $this->proveedor->nombre . " - " . $this->nombre.' ['.$this->lugar_inicio->nombre.' - '.$this->lugar_fin->nombre.']',
                    'servicio_id' => $this->id,
                    'proveedor_id' => $this->proveedor_id,
                    'precios' => []
                ]);
            }
            if($this->tipo_id == 20){ // Paquete
                foreach($this->servicio_precios as $sp){
                    $sp->name = $this->name.' ('.$sp->categoria->nombre.')';
                    $sp->proveedor_id = $this->proveedor_id;
                    $sp->save();
                }
            }
        }
        else { //Update
            if($this->tipo_id == 21){ //Actividad (Tour)                
                if(!$this->servicio_precio->mantener_precios){
                    $rpta = [];
                    for ($i = 1; $i <= 10; $i++) {
                        $costo = 0;
                        $costo_unitario = 0;
                        $confidencial = 0;
                        $confidencial_unitario = 0;
                        $publicado_unitario = 0;
                        $comision_unitario = 0;
                        $reserva_unitario = 0;
                        foreach($this->servicio_items as $incluye){                        
                            $p = $incluye->item->precios[$i - 1];
                            $costo += $p['costo'];
                            $costo_unitario += $p['costo_unitario'];                            
                            $confidencial += $p['confidencial'];
                            $confidencial_unitario += $p['confidencial_unitario'];                            
                            $reserva_unitario += $p['reserva_unitario'];
                            $comision_unitario += $p['comision_unitario'];
                            $publicado_unitario += $p['publicado_unitario'];
                        }
                        $rpta[] = [
                            "nro_pax" => $i,
                            "costo" => $costo,
                            "costo_unitario" => round($costo_unitario, 2),
                            "confidencial" => $this->confidencial ? $this->confidencial * $i : round($confidencial, 2),
                            "confidencial_unitario" => $this->confidencial ? $this->confidencial : round($confidencial_unitario, 2),
                            "reserva_unitario" => $this->reserva ? $this->reserva : round($reserva_unitario, 2),
                            "comision_unitario" => $this->comision ? $this->comision : round($comision_unitario, 2),
                            "publicado_unitario" => $this->publicado ? $this->publicado : round($publicado_unitario, 2),
                        ];
                    }                
                    $this->precios = $rpta;
                }
            }
            if($this->tipo_id == 20){ //Paquete
                foreach($this->servicio_precios as $sp){
                    $sp->name = $this->name.' ('.$sp->categoria->nombre.')';
                    if(!$sp->mantener_precios){
                        $rpta = [];
                        for ($i = 1; $i <= 10; $i++) {
                            $costo = 0;
                            $costo_unitario = 0;
                            $confidencial = 0;
                            $confidencial_unitario = 0;
                            $publicado_unitario = 0;
                            $comision_unitario = 0;
                            $reserva_unitario = 0;
                            foreach($this->servicio_items as $incluye){
                                if($incluye->categorias->contains($sp->categoria_id)){
                                    $p = $incluye->item->precios[$i - 1];
                                    $costo += $p['costo'];
                                    $costo_unitario += $p['costo_unitario'];
                                    $confidencial += $p['confidencial'];
                                    $confidencial_unitario += $p['confidencial_unitario'];
                                    $reserva_unitario += $p['reserva_unitario'];
                                    $comision_unitario += $p['comision_unitario'];
                                    $publicado_unitario += $p['publicado_unitario'];
                                }
                            }
                            $rpta[] = [
                                "nro_pax" => $i,
                                "costo" => $costo,
                                "costo_unitario" => round($costo_unitario, 2),
                                /*"confidencial" => round($confidencial, 2),
                                "confidencial_unitario" => round($confidencial_unitario, 2),
                                "reserva_unitario" => round($reserva_unitario, 2),
                                "comision_unitario" => round($comision_unitario, 2),
                                "publicado_unitario" => round($publicado_unitario, 2),*/
                                "confidencial" => $sp->confidencial ? $sp->confidencial * $i : round($confidencial, 2),
                                "confidencial_unitario" => $sp->confidencial ? $sp->confidencial : round($confidencial_unitario, 2),
                                "reserva_unitario" => $sp->reserva ? $sp->reserva : round($reserva_unitario, 2),
                                "comision_unitario" => $sp->comision ? $sp->comision : round($comision_unitario, 2),
                                "publicado_unitario" => $sp->publicado ? $sp->publicado : round($publicado_unitario, 2),
                            ];
                        }                
                        $sp->precios = $rpta;                
                        $sp->save();
                    }
                }
            
            }
        }    
        Session::forget('servicio_existe?');
    }    
}
