<?php namespace Soroche\Wayna\Models;

use Model;
use BackendAuth;
use Soroche\Wayna\Classes\PlanReservas;

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
        'params',
        'costos',
        'itinerario',
        'adicionales',
        'vuelos',
        'plan',
        'obs'
    ];
    
    /*---------- Relaciones -------------*/
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
            'order' => 'acomodacion',
        ],
    ];
    
    public $morphMany = [
        'pagos' => [
            'Soroche\Wayna\Models\PagoReserva', 
            'name' => 'pagable',
        ],
    ];
    
    /*---------- Atributos -------------*/
    public function getLiderAttribute(){
        $lider = count($this->paxs) ? $this->paxs[0] : null;
        
        foreach($this->paxs as $paxs){
            if($paxs->lider)
                $lider = $paxs;
        }
        
        return $lider;
    }
    
    public function getRidAttribute(){
        return (isset($this->id)? sprintf('R%04d-%s', $this->id, date('Y',strtotime($this->created_at))): '');
    }
    
    public function getPersonalizadoAttribute(){
        return !isset($this->servicio);
    }
    
    public function getTrenesAttribute(){
        $rpta = [];
        
        foreach ($this->plan as $t => $tipoItem)        
            foreach ($tipoItem['proveedores'] as $p => $proveedorItem)
                #if(mb_substr($proveedorItem['nombre'], 5) == 'Peru Rail' || mb_substr($proveedorItem['nombre'], 5) == 'CONSETUR')
                if(mb_substr($proveedorItem['nombre'], 5) == 'Peru Rail')
                    foreach ($proveedorItem['servicios'] as $s => $servicioItem)
                        $rpta[] = [
                            'fecha' => $servicioItem['fecha'],
                            'servicio' => Servicio::find($servicioItem['concepto']),
                            'salida' => (array_key_exists('salida', $servicioItem) && !empty($servicioItem['salida']) ? $servicioItem['salida'] : 'Pendiente'),
                            'llegada' => (array_key_exists('llegada', $servicioItem) && !empty($servicioItem['llegada']) ? $servicioItem['llegada'] : 'Pendiente')
                        ];
        
        return $rpta;
    }
    
    public function getEntradasAttribute(){
        $rpta = [];
        
        foreach ($this->plan as $t => $tipoItem)        
            foreach ($tipoItem['proveedores'] as $p => $proveedorItem)
                if(mb_substr($proveedorItem['nombre'], 5) == 'TuBoleto Cultura' || mb_substr($proveedorItem['nombre'], 5) ==  'COSITUC BTG')
                    foreach ($proveedorItem['servicios'] as $s => $servicioItem)
                        $rpta[] = [
                            'fecha' => $servicioItem['fecha'],
                            'servicio' => (array_key_exists('hora', $servicioItem) && !empty($servicioItem['hora']) ? '' : 'Pendiente - ').Servicio::find($servicioItem['concepto'])->nombre,
                            'hora' => (array_key_exists('hora', $servicioItem) && !empty($servicioItem['hora']) ? $servicioItem['hora'] : 'No aplica'),
                        ];
        
        return $rpta;
    }

    public function getFacturacionAttribute(){
        $hotel = '';
        $trenes = '';
        $tours = '';
        
        if(!isset($this->plan))
            return '';

        foreach ($this->plan as $t => $tipoItem){
            if(mb_substr($tipoItem['nombre'], 5) == 'Alojamiento')
                $hotel = mb_substr($tipoItem['nombre'], 3, 1);
            if(mb_substr($tipoItem['nombre'], 5) == 'Trenes y transporte')
                $trenes = mb_substr($tipoItem['nombre'], 3, 1);
            if(mb_substr($tipoItem['nombre'], 5) == 'Tour Endoce')
                $tours = mb_substr($tipoItem['nombre'], 3, 1);
        }

        return "$trenes$hotel$tours";
    }
    
    /*---------- Combos -------------*/
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
    
    public function getFechasOptions(){
        $rpta = [];
        
        foreach($this->itinerario as $item)
            if(array_key_exists('fecha', $item) && !empty($item['fecha']))
                $rpta[$item['fecha']] = date('d/m', strtotime($item['fecha']));
                
        return $rpta;
    }
    
    public function getDataTableOptions($columnName, $rowData){
        $rpta = [];
        if($rowData == 'pasajeros'){
            $rpta = $this->paxs()->lists('nombres', 'nombres');
            $rpta['Todos'] = 'Todos';
        }
        if($rowData == 'concepto'){
            $user = BackendAuth::getUser();
            $rpta = Servicio::where('negocio_id', '<>', $user->negocio_id)->orderBy('name', 'asc')->lists('name', 'id');
            //trace_log($rpta);
        }
        //trace_log("Colunm: $columnName - Row: $rowData");
        return $rpta;
    }
    
    /*---------- Eventos -------------*/

    public function beforeSave(){        
        $user = BackendAuth::getUser();
        
        if(!$this->exists){ //CREATE
            if(!$this->negocio_id)
                $this->negocio_id = $user->negocio_id;
            if(!$this->user_id)
                $this->user_id = $user->id;
            $this->generarCodigoReserva();
            
            if(!$this->personalizado){ //Base Paquete
                $this->importarItems();
                $this->params = $this->servicio->params;
                $this->precios = $this->servicio->precios;
            }
            if($this->personalizado){ //Personalizado
                $this->items = [];
                $this->params = $user->negocio->params;
                $this->precios = [[0=>'TOTAL',1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0]];
            }
        }
        else { //UPDATE
            $this->actualizarItemsAdicionalesCostos();
            $this->params = $this->servicio->params;
            $this->precios = $this->servicio->precios;
            
            //if($this->estado == 'Confirmado' && !isset($this->plan)){ //<--- cambiar estado
            if($this->estado == 'Plan'){
                /*
                INICIO: PTJA - 2025-08-15
                */
                $plan = PlanReservas::generar($this);
                $this->plan = $plan->render();
                //trace_log($this->plan);
                /*
                $this->generarPlanReservas();
                $this->formatearPlanReservas();
                FIN
                */
            }
            if($this->estado == 'Confirmado'){
                /*
                INICIO: PTJA - 2025-08-15
                */
                $plan = PlanReservas::cargar($this);
                $this->plan = $plan->render();
                //trace_log($this->plan);
                /*
                $this->formatearPlanReservas();
                FIN
                */
                
            }
                
        }
        //CREATE & UPDATE
        $this->generarItinerario();
        $this->formatearName();
        $this->calcularTotales();
        $this->fecha_fin = $this->getFechaFin();
    }
    
    public function filterFields($fields, $context = null)
    {
        if ($context == 'update'){
            $fields->servicio->readOnly = true;
            if($this->personalizado){
                $fields->cotizacion->hidden = true;
            }
            if(!$this->personalizado){
                $fields->costos->hidden = true;
                $fields->resumen->hidden = true;
                $fields->params->readOnly = true;
            }
        }
    }
    
    /*---------- Metodos -------------*/

    public function itinerarioPorFecha(){
        $rpta = [];
        foreach($this->itinerario as $item)
                $rpta[$item['fecha']] = $item;
        return $rpta;
    }
    
    public function serviciosPorFecha(){
        $rpta[] = [];
        
        foreach ($this->plan as $t => $tipoItem){
            if(mb_substr($tipoItem['nombre'], 5) == 'Entradas' || mb_substr($tipoItem['nombre'], 5) == 'Trenes y transporte' || mb_substr($tipoItem['nombre'], 5) == 'Tour Endoce'  || mb_substr($tipoItem['nombre'], 5) == 'Alimentacion')
                foreach ($tipoItem['proveedores'] as $p => $proveedorItem)
                    foreach ($proveedorItem['servicios'] as $s => $servicioItem){
                        $si = $servicioItem;
                        $si['servicio'] = Servicio::find($si['concepto'])->nombre;
                        $si['tipo'] = 'tour';
                        $si['confirmado'] = $this->getCheck($proveedorItem['estados'][1]['nombre']);
                        $si['pagado'] = $this->getCheck($proveedorItem['estados'][2]['nombre']);
                        $rpta[$servicioItem['fecha']]['servicios'][] = $si;
                        if(!array_key_exists('costo', $rpta[$servicioItem['fecha']]) || empty($rpta[$servicioItem['fecha']]['costo'])){
                            $rpta[$servicioItem['fecha']]['costo'] = 0;
                            $rpta[$servicioItem['fecha']]['pago'] = 0;
                            $rpta[$servicioItem['fecha']]['fact'] = 0;
                        }
                        $rpta[$servicioItem['fecha']]['costo'] += empty($si['costo']) ? 0 : $si['costo'];
                        $rpta[$servicioItem['fecha']]['pago'] += empty($si['pago']) ? 0 : $si['pago'];
                        $rpta[$servicioItem['fecha']]['fact'] += empty($si['fact']) ? 0 : $si['fact'];
                    }
        }
        foreach ($this->plan as $t => $tipoItem){
            if(mb_substr($tipoItem['nombre'], 5) == 'Alojamiento')
                foreach ($tipoItem['proveedores'] as $p => $proveedorItem)
                    foreach ($proveedorItem['fechas'] as $fecha)
                        foreach ($proveedorItem['servicios'] as $s => $servicioItem){
                            $si = $servicioItem;
                            $s = Servicio::find($si['concepto']);
                            $si['servicio'] = $s->name;
                            $si['nombre'] = $s->nombre;
                            $si['tipo'] = 'hotel';
                            $si['confirmado'] = $this->getCheck($proveedorItem['estados'][1]['nombre']);
                            $si['pagado'] = $this->getCheck($proveedorItem['estados'][2]['nombre']);
                            $rpta[date('d/m/Y', strtotime($fecha))]['servicios'][] = $si;
                            if(!array_key_exists('costo', $rpta[date('d/m/Y', strtotime($fecha))]) || empty($rpta[date('d/m/Y', strtotime($fecha))]['costo'])){
                                $rpta[date('d/m/Y', strtotime($fecha))]['costo'] = 0;
                                $rpta[date('d/m/Y', strtotime($fecha))]['pago'] = 0;
                                $rpta[date('d/m/Y', strtotime($fecha))]['fact'] = 0;
                            }
                            $rpta[date('d/m/Y', strtotime($fecha))]['costo'] += $si['costo'];
                            $rpta[date('d/m/Y', strtotime($fecha))]['pago'] += empty($si['pago']) ? 0 : $si['pago'];
                            $rpta[date('d/m/Y', strtotime($fecha))]['fact'] += empty($si['fact']) ? 0 : $si['fact'];
                        }
        }
        return $rpta;
    }
    
    public function entradaPorFecha($fecha){
        $rpta = '';
        
        if(isset($this->plan))
        foreach ($this->plan as $t => $tipoItem)        
            foreach ($tipoItem['proveedores'] as $p => $proveedorItem)
                if(mb_substr($proveedorItem['nombre'], 5) == 'TuBoleto Cultura')
                    foreach ($proveedorItem['servicios'] as $s => $servicioItem)
                        if(date('d/m/Y', strtotime($fecha)) == $servicioItem['fecha'])
                            $rpta = (array_key_exists('hora', $servicioItem) && !empty($servicioItem['hora']) ? ' ('.$servicioItem['hora'].')' : '');
        
        return $rpta;
    }
    
    public function trenPorFecha($fecha){
        $rpta = '';

        if(isset($this->plan))
        foreach ($this->plan as $t => $tipoItem)        
            foreach ($tipoItem['proveedores'] as $p => $proveedorItem)
                if(mb_substr($proveedorItem['nombre'], 5) == 'Peru Rail')
                    foreach ($proveedorItem['servicios'] as $s => $servicioItem)
                        if(date('d/m/Y', strtotime($fecha)) == $servicioItem['fecha'])
                            $rpta = (array_key_exists('salida', $servicioItem) && !empty($servicioItem['salida']) ? $servicioItem['salida'] : 'ND').'->'.(array_key_exists('llegada', $servicioItem) && !empty($servicioItem['llegada']) ? $servicioItem['llegada'] : 'ND');
        
        return $rpta;
    }
    
    public function hotelPorFecha($fecha, $pendiente){
        $rpta = '';
        
        if(isset($this->plan))
        foreach ($this->plan as $t => $tipo)
        if(mb_substr($tipo['nombre'], 5) == 'Alojamiento'){
            foreach ($tipo['proveedores'] as $p => $proveedorItem){
                if(in_array($fecha, $proveedorItem['fechas'])){
                    $servicio = Servicio::find($proveedorItem['servicios'][0]['concepto']);
                    if($proveedorItem['estados'][1]['nombre'] == 2)
                        $rpta = $servicio->negocio->nombre;
                    else
                        $rpta = 'Pendiente - '.$pendiente;
                }
                    
            }            
        }
        
        return $rpta;
    }
    
    
    private function importarItems(){
        $items = [];
        foreach($this->servicio->items as $i=>$item){
            $tour = Servicio::find($item['tour']);
            $hotel = isset($item['hotel']) ? Servicio::find($item['hotel']) : null;
            $items[] = $this->formatearItem('paquete', $tour, $hotel, $i+1);
        }
        $this->items = $items;
    }
    
    private function actualizarItemsAdicionalesCostos(){
        $items = $this->items; 
        $dia = 0;
        
        $adicionales = [];
        $costos = ['OPERATIVO', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        
        for($i=0; $i < count($items); $i++){
            $item = $items[$i];
            $tour = Servicio::find($item['_group'] == 'adicional' ? $item['actividad'] : $item['tour']);
            $hotel = isset($item['hotel']) ? Servicio::find($item['hotel']) : null;
                        
            if($item['_group'] == 'paquete'){
                $dia++;
                $items[$i] = $this->formatearItem($item['_group'], $tour, $hotel, $dia);
            }
            if($item['_group'] == 'tour'){
                $dia++;
                $items[$i] = $this->formatearItem($item['_group'], $tour, $hotel, $dia);
                $adicionales[] = $this->formatearAdicional($tour, $hotel, $dia);
            }
            if($item['_group'] == 'personalizado'){
                $dia++;
                $items[$i] = $this->formatearItem($item['_group'], $tour, $hotel, $dia);
                $costos['servicios'][] = $this->formatearCostos($tour, $hotel, $dia, $costos);
            }
            if($item['_group'] == 'adicional'){                
                $items[$i] = $this->formatearItem('adicional', $tour, null, $dia);
                $adicionales[] = $this->formatearAdicional($tour, null, $dia);
            }
        }
        $this->items = $items;
        $this->adicionales = $adicionales;
        $this->costos = $costos;
    }
    
    private function formatearCostos($tour, $hotel, $dia, &$costos){
        $rpta = [
            0 => 'Dia '.($dia).'. '.$tour->nombre,
            'servicios' => $tour->costos['operativo']['servicios']
        ];
        
        if(isset($hotel)){
            $h = $hotel->costos['operativo'];
            $h[0] = "↳ $hotel->nombre";
            $rpta['servicios'][] = $h;
        }
        
        for($i=1; $i<=10; $i++){
            $rpta[$i] = $tour->costos['operativo'][$i] + (isset($hotel) ? $hotel->costos['operativo'][$i] : 0);
            $costos[$i] += $rpta[$i];
        }
        
        return $rpta;
    }
    
    private function formatearAdicional($tour, $hotel, $dia){
        $index = $dia - 1;
        $rpta = [
            'nombre' => $tour->nombre . (isset($hotel) ? " + $hotel->nombre" : ''),
            'fecha' => isset($this->fecha_inicio) ? date('Y-m-d', strtotime($this->fecha_inicio. " + $index days")) : null,
        ];
        for($i=1; $i<=10; $i++)
            $rpta[$i] = $tour->precios[0][$i] + (isset($hotel) ? $hotel->precios[0][$i] : 0);
        
        return $rpta;
    }
    
    private function formatearItem($tipo, $tour, $hotel, $dia){
        $index = $dia - 1;
        $fecha = isset($this->fecha_inicio) ? date('Y-m-d', strtotime($this->fecha_inicio. " + $index days")) : null;     
        $nombre = $tipo == 'adicional' ? "↳ $tour->nombre" : 'Dia '.($dia).'. '.(isset($fecha)? date('(d/m): ', strtotime($fecha)) : ' ').$tour->nombre. (isset($hotel) ? " + $hotel->nombre" : '');
        
        if($tipo == 'adicional')
            return [
                '_group' => $tipo,
                'nombre' => $nombre,
                'dia' => $dia,
                'fecha' => $fecha,
                'actividad' => $tour->id,
            ];
        else
            return [
                '_group' => $tipo,
                'nombre' => $nombre,
                'dia' => $dia,
                'fecha' => $fecha,
                'tour' => $tour->id,
                'hotel' => (isset($hotel) ? $hotel->id : null)
            ];
    }
    
    private function generarItinerario(){
        $itinerario = [];
        
        foreach($this->items as $item){
            if($item['_group'] == 'paquete' || $item['_group'] == 'tour' || $item['_group'] == 'personalizado'){
                $itinerario[$item['dia']]['nombre'] = $item['nombre'];
                $itinerario[$item['dia']]['dia'] = $item['dia'];
                $itinerario[$item['dia']]['fecha'] = $item['fecha'];
                $tour = Servicio::find($item['tour']);
                $itinerario[$item['dia']]['tour'] = $tour->nombre;
                $hotel = Servicio::find($item['hotel']);
                $itinerario[$item['dia']]['hotel'] = isset($hotel) ? $hotel->nombre : null;
                
                if(isset($this->vuelos) && isset($this->vuelos[0]['fecha']))
                    foreach($this->vuelos as $vuelo)
                        if(date('d/m/Y', strtotime($item['fecha'])) == $vuelo['fecha'])
                            $itinerario[$item['dia']]['vuelo'] = $vuelo['salida'].'->'.$vuelo['llegada'];
                
                foreach($tour->items as $servicioItem)
                    foreach($servicioItem['incluye'] as $in)
                        if(isset($in['dia']))
                            $itinerario[$item['dia'] + $in['dia']]['incluye'][] = $in['nombre'];
                if(isset($hotel))
                    foreach($hotel->items as $servicioItem)
                        foreach($servicioItem['incluye'] as $in)
                            if(isset($in['dia']))
                                $itinerario[$item['dia'] + $in['dia']]['incluye'][] = $in['nombre'];
                
                foreach($tour->no_incluye as $ni)
                    if(isset($ni['dia']))
                        $itinerario[$item['dia'] + $ni['dia']]['no_incluye'][] = $ni['nombre'];
                
                if(isset($hotel) && isset($hotel->no_incluye))
                    foreach($hotel->no_incluye as $ni)
                        if(isset($ni['dia']))
                            $itinerario[$item['dia'] + $ni['dia']]['no_incluye'][] = $ni['nombre'];
            }
            
            if($item['_group'] == 'adicional'){
                $actividad = Servicio::find($item['actividad']);
                
                foreach($actividad->items as $servicioItem)
                    foreach($servicioItem['incluye'] as $in)
                        if(isset($in['dia']))
                            $itinerario[$item['dia'] + $in['dia']]['incluye'][] = $in['nombre'].'*';
                if(isset($actividad->no_incluye))
                    foreach($actividad->no_incluye as $ni)
                        if(isset($ni['dia']))
                            $itinerario[$item['dia'] + $ni['dia']]['no_incluye'][] = $ni['nombre'].'*';
            }
            
        }
        
        $this->itinerario = $itinerario;
    }
    
   
    private function formatearName(){
        $name = 'Nueva Reserva';
        
        $name = isset($this->fecha_inicio) ? date('Y-m-d', strtotime($this->fecha_inicio)) : 'Abierto';
        $name .= ' -- '.(isset($this->lider) ? $this->lider->fullname : 'Grupo de '.$this->user->fullname);
        $name .= ' x'.$this->nro_paxs;
        $name .= ' - '.(isset($this->servicio) ? $this->servicio->nombre : 'Paquete Personalizado '.count($this->itinerario).'D' );
        $name .= ' - '.$this->rid;
        
        $this->name = $name;
    }
    
    private function generarCodigoReserva($longitud = 8) {
        do{
            $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $codigo = substr(str_shuffle($caracteres), 0, $longitud);
        }
        while (self::where('codigo', $codigo)->exists());
        $this->codigo = $codigo;
    }
    
    public function precioTotal($nroPaxs){
        $rpta = $this->precios[0][$nroPaxs > 10 ? 10 : $nroPaxs];
        if(isset($this->adicionales))
            foreach($this->adicionales as $adicional)
                $rpta += $adicional[$nroPaxs];
        
        return $rpta;
    }
    
    
    public function costoTotal($nroPaxs){
        $rpta = 0;
        $rpta += $this->costos[$nroPaxs > 10 ? 10 : $nroPaxs];
        $rpta += $this->params[0]['pasarela'] * $this->params[0]['adelanto'];
        $rpta += $this->params[0]['igv'] * $this->params[0]['adelanto'];
        $rpta += $this->params[0]['ir'] * $this->params[0]['adelanto'];
        $rpta += $this->params[0]['comision'];
        
        return $rpta;
    }
    
    private function calcularTotales(){
        $pagos = 0;
        $total = $this->precioTotal($this->nro_paxs > 10 ? 10 : $this->nro_paxs) * $this->nro_paxs;
        $comision = $this->params[0]['comision'] * $this->nro_paxs;
        foreach($this->pagos as $pago){
            $pagos += $pago->monto;
        }
        
        $this->total = $total;
        $this->totalpagos = $pagos;
        $this->comision = $comision;
    }

    private function getFechaFin(){
        $fecha_fin = null;
        
        foreach($this->items as $item)
            if($item['_group'] == 'paquete' || $item['_group'] == 'tour')
                $fecha_fin = $item['fecha'];
        
        return $fecha_fin;
    }

    private function getCheck($estado){
        $rpta = '';
        
        if($estado == 2 || $estado == 3)
            $rpta = '✅';
        if($estado == 1)
            $rpta = '🟨';
        if($estado == 0)
            $rpta = '🟧';
        
        return $rpta;
    }

    /*---------- Scopes -------------*/

    public function scopePorRangoFechas($query, $inicio, $fin)
    {
        $query->where('fecha_inicio', '<=', $fin)
              ->where('fecha_fin', '>=', $inicio);

        return $query;
    }
}






