<?php namespace Soroche\Wayna\Models;

use Model;
use BackendAuth;
use Log;

/**
 * Model
 */
class Servicio extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'soroche_wayna_servicios';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [
        'params', 
        'precios', 
        'costos', 
        'margen',
        'items'
    ];
    
    public $belongsTo = [        
        'lugar' => [
            'soroche\Wayna\Models\Tipo', 'conditions' => "tipo = 'Lugar'"
        ],
        'negocio' => [
            'soroche\Wayna\Models\Negocio'
        ],
        'servicio' => [
            'soroche\Wayna\Models\Servicio'
        ],
        'alojamiento' => [
            'soroche\Wayna\Models\Servicio'
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
    
    public function getNegocioOptions(){    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        $rpta = Negocio::join('soroche_wayna_proveedores', 'soroche_wayna_negocios.id', '=', 'soroche_wayna_proveedores.proveedor_id')
                ->where('soroche_wayna_proveedores.negocio_id',$user->negocio_id)->get()->lists('nombre', 'proveedor_id');
        
        return $rpta;
    }
    
    public function filterFields($fields, $context = null)
    {   
        if ($context == 'create') {
            $user = BackendAuth::getUser();
            $this->params = $user->negocio->params;
        }
    }
    
    public function beforeSave(){        
        if($this->exists){ //UPDATE
            if($this->tipo == 'Paquete'){
                $this->calcularCostosPaquete();
                $this->calcularMargen();
            }
            elseif($this->tipo == 'Tour'){
                $this->calcularCostosTour();
                $this->calcularMargen();
            }
            
        }
    }
    
    public function beforeCreate(){
        $user = BackendAuth::getUser();
        if($this->tipo == 'Paquete'){
            if(!$this->negocio_id)
                $this->negocio_id = $user->negocio_id;
            
            //-------Name
            $name = sprintf('%s - %s',$this->negocio->nombre,$this->nombre);
            $this->name = $name;
            
            $this->calcularCostosPaquete();            
            $this->calcularPrecios();            
            $this->calcularMargen();
        }
        elseif($this->tipo == 'Tour'){
            if(!$this->negocio_id)
                $this->negocio_id = $user->negocio_id;
            
            //-------Name
            $name = sprintf('%s - %s',$this->negocio->nombre,$this->nombre);
            $this->name = $name;
            
            $this->calcularCostosTour();
            $this->calcularPrecios();            
            $this->calcularMargen();
        }
        else{
            //-------Name
            $name = sprintf(
                '%s %s - %s x%d: USD %.2f',
                $this->negocio->nombre,
                $this->negocio->categoria=='No categorizado'?'':' ('.$this->negocio->categoria.')',
                $this->nombre,
                $this->capacidad,
                $this->costo
            );
            $this->name = $name;
            
            $this->calcularCostosServicio();
        }
    }
    
    private function calcularCostosServicio(){
        //-------costos
        $costos = [];
        $costos[0][0] = $this->nombre;
        for($i=1; $i<=10; $i++){
            $costos[0][strval($i)] = (intdiv($i-1, $this->capacidad)+1)*$this->costo;
        } 
        $this->costos = $costos;
    }
    
    private function calcularCostosTour(){
        $costos = [];
        $costos['total'][0] = 'TOTAL';
        $costos['operativo'][0] = 'OPERATIVO';
        $costos['pasarela'][0] = 'PASARELA ('.($this->params[0]['pasarela']*100).'%)';
        $costos['igv'][0] = 'IGV ('.($this->params[0]['igv']*100).'%)';
        $costos['ir'][0] = 'IR ('.($this->params[0]['ir']*100).'%)';
        $costos['comision'][0] = 'COMISION';
        
        
        for($i=1; $i<=10; $i++){
            $costos['total'][$i] = 0;
            $costos['operativo'][$i] = 0;            
            $costos['pasarela'][$i] = $this->params[0]['adelanto']*$this->params[0]['pasarela'];
            $costos['igv'][$i] = round($this->params[0]['adelanto']-$this->params[0]['adelanto']/(1+$this->params[0]['igv']));
            $costos['ir'][$i] = ($this->params[0]['adelanto']-$this->params[0]['facturable'])*$this->params[0]['ir'];
            $costos['comision'][$i] = $this->params[0]['comision'];
        }
        
        $p = [];
        for($j=0; $j < count($this->items); $j++){
            
            $servicio = Servicio::find($this->items[$j]['servicio']);
            
            $p[0] = ' ↳ '.$servicio->nombre;
            for($i=1; $i<=10; $i++){
                $p[$i] = round($servicio->costos[0][$i] / $i,2);
                $costos['operativo'][$i] += $p[$i];
            }
            $costos['operativo']['servicios'][] = $p;
        }
        
        for($i=1; $i<=10; $i++){
            $costos['total'][$i] = 
                $costos['operativo'][$i] +
                $costos['pasarela'][$i] +
                $costos['igv'][$i] +
                $costos['ir'][$i] +
                $costos['comision'][$i];
        }
        
        $this->costos = $costos;            
    }
    
    private function calcularCostosPaquete(){
        $costos = [];
        $costos['total'][0] = 'TOTAL';
        $costos['operativo'][0] = 'OPERATIVO';
        $costos['pasarela'][0] = 'PASARELA ('.($this->params[0]['pasarela']*100).'%)';
        $costos['igv'][0] = 'IGV ('.($this->params[0]['igv']*100).'%)';
        $costos['ir'][0] = 'IR ('.($this->params[0]['ir']*100).'%)';
        $costos['comision'][0] = 'COMISION';
        
        for($i=1; $i<=10; $i++){
            $costos['total'][$i] = 0;
            $costos['operativo'][$i] = 0;            
            $costos['pasarela'][$i] = $this->params[0]['adelanto']*$this->params[0]['pasarela'];
            $costos['igv'][$i] = round($this->params[0]['adelanto']-$this->params[0]['adelanto']/(1+$this->params[0]['igv']));
            $costos['ir'][$i] = ($this->params[0]['adelanto']-$this->params[0]['facturable'])*$this->params[0]['ir'];
            $costos['comision'][$i] = $this->params[0]['comision'];
        }
        
        $p = [];
        for($j=0; $j < count($this->items); $j++){
            
            $servicio = Servicio::find($this->items[$j]['servicio']);
            
            $tour = $servicio->costos['operativo'];
            $tour[0] = 'DIA '.($j+1).': '.$servicio->nombre;
            
            if(isset($this->items[$j]['alojamiento'])){
                $sp = Servicio::find($this->items[$j]['alojamiento']);
                $spc = [];
                $spc[0] = ' ↳ '.$sp->nombre;
                for($i=1; $i<=10; $i++){
                    $spc[$i] = round($sp->costos[0][$i] / $i);
                    $tour[$i] += $spc[$i];
                }
                $tour['servicios'][] = $spc;
            }
            $costos['operativo']['servicios'][] = $tour;
                        
            for($i=1; $i<=10; $i++){                
                $costos['operativo'][$i] += $costos['operativo']['servicios'][$j][$i];
            }
        }
        
        for($i=1; $i<=10; $i++){
            $costos['total'][$i] = 
                $costos['operativo'][$i] +
                $costos['pasarela'][$i] +
                $costos['igv'][$i] +
                $costos['ir'][$i] +
                $costos['comision'][$i];
        }
        
        $this->costos = $costos;
    }
    
    private function calcularPrecios(){
        $precios = [];
        $precios[0][0] = 'TOTAL';
        for($i=1; $i<=10; $i++){
            $precios[0][$i] = round($this->costos['total'][$i] * 1.20, 2);
        }
        $this->precios = $precios;    
    }
    private function calcularMargen(){
        $margen = [];
        
        $margen[0][0] = 'TOTAL';
        $x = [];
        $c = [];
        $x[0] = ' ↳ Socio';
        $c[0] = ' ↳ Caja';
        for($i=1; $i<=10; $i++){
            $m = round($this->precios[0][$i] - $this->costos['total'][$i], 2);
            $margen[0][$i] = $m;
            $x[$i] = round($m * 0.45, 2);
            $c[$i] = round($m * 0.1, 2);
        }
        $margen[] = $x;
        $margen[] = $c;
        $this->margen = $margen;
    }
}
