<?php namespace Soroche\Wayna\Models;

use Model;
use BackendAuth;

/**
 * Model
 */
class Reserva extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

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
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [
        'items',
        'precios',
        'vuelos'
    ];
    
    public $belongsTo = [
        'negocio' => [
            'soroche\Wayna\Models\Negocio'
        ],
        'servicio' => [
            'soroche\Wayna\Models\Servicio'
        ],
        'user' => [
            'Backend\Models\User'
        ],
        'actividad' => [
            'soroche\Wayna\Models\Servicio'
        ],
    ];
    
    public $belongsToMany = [
        'paxs' => [
            'soroche\Wayna\Models\Pax',
            'table' => 'soroche_wayna_reserva_paxs',
        ],
    ];
    
    public $morphMany = [
        'pagos' => [
            'Soroche\Wayna\Models\PagoReserva', 
            'name' => 'pagable',
        ],
    ];
    
    public function getLiderAttribute(){
        $lider = count($this->paxs) ? $this->paxs[0] : null;
        
        foreach($this->paxs as $paxs){
            if($paxs->lider)
                $lider = $paxs;
        }
        
        return $lider;
    }
    
    public function getServicioOptions(){    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        $rpta = Servicio::where('negocio_id', $user->negocio_id)
                ->whereIn('tipo', ['Paquete','Tour'])
                ->whereIn('estado', ['Interno','Publicado'])->get()->lists('nombre', 'id');
        
        return $rpta;
    }
    
    public function getTourOptions(){    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        $rpta = Servicio::where('negocio_id', $user->negocio_id)
                //->whereIn('tipo', ['Paquete','Tour'])
                ->whereIn('tipo', ['Tour'])
                //->whereIn('estado', ['Interno','Publicado'])
                ->get()->lists('nombre', 'id');
        
        return $rpta;
    }
    
    public function getHotelOptions(){    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        $rpta = Servicio::where('negocio_id', $user->negocio_id)
                //->whereIn('tipo', ['Paquete','Tour'])
                ->whereIn('tipo', ['Tour'])
                //->whereIn('estado', ['Interno','Publicado'])
                ->get()->lists('nombre', 'id');
        
        return $rpta;
    }
    
    public function getActividadOptions(){
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        $rpta = Servicio::where('negocio_id', $user->negocio_id)
                //->whereIn('tipo', ['Paquete','Tour'])
                ->whereIn('tipo', ['Tour'])
                //->whereIn('estado', ['Interno','Publicado'])
                ->get()->lists('nombre', 'id');
        
        return $rpta;
    }
    
    public function getDataTableOptions($columnName, $rowData){
        $rpta = [];
        $rpta = $this->paxs()->lists('nombres', 'nombres');
        $rpta['Todos'] = 'Todos';
        return $rpta;
    }
    
    public function beforeCreate(){
        $user = BackendAuth::getUser();
        
        if(!$this->negocio_id)
            $this->negocio_id = $user->negocio_id;
        if(!$this->user_id)
            $this->user_id = $user->id;
        $this->generarCodigoReserva();
        $this->importarPaquete();
        
        $this->formatearName();   
        
        $this->calcularTotales();
        
    }
    public function beforeSave(){        
        if($this->exists){ //UPDATE
            $this->importarAdicionales();
            
            $this->formatearName();
            
            $this->calcularTotales();
            
        }
    }
    
    public function filterFields($fields, $context = null)
    {
        if ($context == 'update')
            $fields->servicio->readOnly = true;
    }
    
    private function importarAdicionales(){
        $items = $this->items;        
        $dia = 0;
        
        $precios = $this->precios;
        $precios['adicionales'] = [];
        for($i=1; $i<=10; $i++)
            $precios['adelanto'][$i] = $this->servicio->params[0]['adelanto'];
        for($i=1; $i<=10; $i++)
            $precios['comision'][$i] = $this->servicio->params[0]['comision'];
        
        for($i=0; $i < count($items); $i++){
            if($items[$i]['_group'] == 'paquete'){
                $dia++;
                $tour = Servicio::find($items[$i]['tour']);
                $hotel = isset($items[$i]['hotel']) ? Servicio::find($items[$i]['hotel']) : null;
                
                $tour_nombre = $tour->nombre;
                $hotel_nombre = isset($hotel) ? $hotel->nombre : null;
                
                $items[$i]['dia'] = $dia;
                $fecha = isset($this->fecha_inicio) ? date('Y-m-d', strtotime($this->fecha_inicio. " + ".($dia-1)." days")) : null;
                $items[$i]['fecha'] = $fecha;
                $items[$i]['nombre'] = "Dia $dia.".(isset($fecha)? date(' (d/m):', strtotime($fecha)) : '')." $tour_nombre".(isset($hotel_nombre) ? " + $hotel_nombre" : '');
            }
            if($items[$i]['_group'] == 'tour'){
                $dia++;
                $tour = Servicio::find($items[$i]['tour']);
                $hotel = isset($items[$i]['hotel']) ? Servicio::find($items[$i]['hotel']) : null;
                
                $tour_nombre = $tour->nombre;
                $hotel_nombre = isset($hotel) ? $hotel->nombre : null;
                
                $items[$i]['dia'] = $dia;
                $fecha = isset($this->fecha_inicio) ? date('Y-m-d', strtotime($this->fecha_inicio. " + ".($dia-1)." days")) : null;
                $items[$i]['fecha'] = $fecha;
                $items[$i]['nombre'] = "Dia $dia.".(isset($fecha)? date(' (d/m):', strtotime($fecha)) : '')." $tour_nombre".(isset($hotel_nombre) ? " + $hotel_nombre" : '');
                
                $items[$i]['tour_servicios'] = $tour->items;
                $items[$i]['tour_no_incluye'] = $tour->no_incluye;
                $items[$i]['hotel_servicios'] = isset($hotel) ? $hotel->items : [];
                $items[$i]['hotel_no_incluye'] = isset($hotel) ? $hotel->no_incluye : [];
                
                //Precios
                $pd = [];
                for($p=0; $p<=10; $p++)
                if($p ==  0){
                    $pd['nombre'] = $tour_nombre.(isset($hotel_nombre)? " + $hotel_nombre" : '');
                    $pd['fecha'] = $fecha;
                }
                else
                    $pd[$p] = $tour->precios[0][$p] + (isset($hotel)?$hotel->precios[0][$p] : 0);
                $precios['adicionales'][] = $pd;
                
                //Adelanto
                for($j=1; $j<=10; $j++)
                    $precios['adelanto'][$j] += $tour->params[0]['adelanto'] + (isset($hotel)?$hotel->params[0]['adelanto'] : 0);
                //Comision
                for($j=1; $j<=10; $j++)
                    $precios['comision'][$j] += $tour->params[0]['comision'] + (isset($hotel)?$hotel->params[0]['comision'] : 0);
            }
            if($items[$i]['_group'] == 'adicional'){
                $actividad = Servicio::find($items[$i]['actividad']);
                $nombre = $actividad->nombre;
                $items[$i]['dia'] = $dia;
                $fecha = isset($this->fecha_inicio) ? date('Y-m-d', strtotime($this->fecha_inicio. " + ".($dia-1)." days")) : null;
                $items[$i]['fecha'] = $fecha;
                $items[$i]['nombre'] = "↳ $nombre";
                $items[$i]['servicios'] = $actividad->items;
                $items[$i]['no_incluye'] = $actividad->no_incluye;
                
                //Precios
                $pd = [];
                for($p=0; $p<=10; $p++)
                if($p ==  0){
                    $pd['nombre'] = $nombre;
                    $pd['fecha'] = $fecha;
                }
                else
                    $pd[$p] = $actividad->precios[0][$p];
                $precios['adicionales'][] = $pd;
                
                //Adelanto
                for($j=1; $j<=10; $j++)
                    $precios['adelanto'][$j] += $actividad->params[0]['adelanto'];
                //Comision
                for($j=1; $j<=10; $j++)
                    $precios['comision'][$j] += $actividad->params[0]['comision'];
            }
        }
        
        //Precio Total        
        for($i=1; $i<=10; $i++){
            $precios['total'][$i] = $precios['paquete'][$i];
            foreach($precios['adicionales'] as $adicional)
                $precios['total'][$i] += $adicional[$i];
        }
        
        $this->items = $items;
        $this->precios = $precios;
    }
    
    private function importarPaquete(){
        //Importar Items (Tours, Servicios, Incluyes y No incluyes
        $items = [];
        foreach($this->servicio->items as $i=>$item){
                    
            $tour = Servicio::find($item['tour']);
            $hotel = isset($item['hotel']) ? Servicio::find($item['hotel']) : null;
            
            $tour_nombre = $tour->nombre;
            $hotel_nombre = isset($hotel) ? $hotel->nombre : null;
            $fecha = isset($this->fecha_inicio) ? date('Y-m-d', strtotime($this->fecha_inicio. " + $i days")) : null;
            
            $nombre = 'Dia '.($i+1).'. '.(isset($fecha)? date('(d/m): ', strtotime($fecha)) : ' ').$tour_nombre. (isset($hotel_nombre) ? " + $hotel_nombre" : '');
            
            $items[] = [
                '_group' => 'paquete',
                'nombre' => $nombre,
                'dia' => $i+1,
                'fecha' => $fecha,
                'tour' => $item['tour'],
                'tour_servicios' => $tour->items,
                'tour_no_incluye' => $tour->no_incluye,
                'hotel' => isset($item['hotel']) ? $item['hotel'] : '',                
                'hotel_servicios' => isset($hotel) ? $hotel->items : [],
                'hotel_no_incluye' => isset($hotel) ? $hotel->no_incluye : [],
            ];
        }
        //trace_log($items);
        $this->items = $items;
        
        //Importar Precios
        $precios['paquete'] = $this->servicio->precios[0];
        $precios['paquete']['nombre'] = $this->servicio->nombre;
        $precios['total'] = $this->servicio->precios[0];
        $precios['total']['nombre'] = 'PRECIO TOTAL';
        //Importar Adelanto
        $precios['adelanto'] = [];
        for($i=0; $i<=10; $i++)
        if($i==0)
            $precios['adelanto']['nombre'] = 'ADELANTO';
        else
            $precios['adelanto'][$i] = $this->servicio->params[0]['adelanto'];
        //Importar Comision
        $precios['comision'] = [];
        for($i=0; $i<=10; $i++)
        if($i==0)
            $precios['comision']['nombre'] = 'COMISION';
        else
            $precios['comision'][$i] = $this->servicio->params[0]['comision'];
                
        $this->precios = $precios;
    }
    
    public function getRidAttribute(){
        return (isset($this->id)? sprintf('R%04d-%s', $this->id, date('Y',strtotime($this->created_at))): '');
    }
    
    private function formatearName(){
        $name = 'Nueva Reserva';
        
        $name = isset($this->fecha_inicio) ? date('Y-m-d', strtotime($this->fecha_inicio)) : 'Abierto';
        $name .= ' -- '.(isset($this->lider) ? $this->lider->fullname : 'Grupo de '.$this->user->fullname);
        $name .= ' x'.$this->nro_paxs;
        $name .= ' - '.$this->servicio->nombre;
        $name .= ' - '.$this->rid;
        
        $this->name = $name;
    }
    
    function generarCodigoReserva($longitud = 8) {
        do{
            $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $codigo = substr(str_shuffle($caracteres), 0, $longitud);
        }
        while (self::where('codigo', $codigo)->exists());
        $this->codigo = $codigo;
    }
    
    private function calcularTotales(){
        $total = 0;
        $pagos = 0;
        $comision = 0;
        
        $total = $this->precios['total'][$this->nro_paxs] * $this->nro_paxs;
        $comision = $this->precios['comision'][$this->nro_paxs] * $this->nro_paxs;
        foreach($this->pagos as $pago){
            $pagos += $pago->monto;
        }
        
        $this->total = $total;
        $this->totalpagos = $pagos;
        $this->comision = $comision;
    }
    
    public function itinerario(){
        $itinerario = [];
        
        foreach($this->items as $item){
            if($item['_group'] == 'paquete' || $item['_group'] == 'tour'){
                $itinerario[$item['dia']]['nombre'] = $item['nombre'];
                $itinerario[$item['dia']]['dia'] = $item['dia'];
                $itinerario[$item['dia']]['fecha'] = $item['fecha'];
                $itinerario[$item['dia']]['tour'] = Servicio::find($item['tour'])->nombre;
                $hotel = Servicio::find($item['hotel']);
                $itinerario[$item['dia']]['hotel'] = isset($hotel) ? $hotel->nombre : null;
                
                if(isset($this->vuelos) && isset($reserva->vuelos[0]['fecha']))
                    foreach($this->vuelos as $vuelo)
                        if(date('d/m/Y', strtotime($item['fecha'])) == $vuelo['fecha'])
                            $itinerario[$item['dia']]['vuelo'] = $vuelo['salida'].'->'.$vuelo['llegada'];
                
                foreach($item['tour_servicios'] as $tour)
                    foreach($tour['incluye'] as $in)
                        if(isset($in['dia']))
                            $itinerario[$item['dia'] + $in['dia']]['incluye'][] = $in['nombre'];
                foreach($item['hotel_servicios'] as $tour)
                    foreach($tour['incluye'] as $in)
                        if(isset($in['dia']))
                            $itinerario[$item['dia'] + $in['dia']]['incluye'][] = $in['nombre'];
                
                if(isset($item['tour_no_incluye']))
                    foreach($item['tour_no_incluye'] as $ni)
                        if(isset($ni['dia']))
                            $itinerario[$item['dia'] + $ni['dia']]['no_incluye'][] = $ni['nombre'];
                if(isset($item['hotel_no_incluye']))
                    foreach($item['hotel_no_incluye'] as $ni)
                        if(isset($ni['dia']))
                            $itinerario[$item['dia'] + $ni['dia']]['no_incluye'][] = $ni['nombre'];
            }
            if($item['_group'] == 'adicional'){
                foreach($item['servicios'] as $tour)
                    foreach($tour['incluye'] as $in)
                        if(isset($in['dia']))
                            $itinerario[$item['dia'] + $in['dia']]['incluye'][] = $in['nombre'].'*';
                if(isset($item['no_incluye']))
                    foreach($item['no_incluye'] as $ni)
                        if(isset($ni['dia']))
                            $itinerario[$item['dia'] + $ni['dia']]['no_incluye'][] = $ni['nombre'].'*';
            }
        }
        
        return $itinerario;
    }
}
