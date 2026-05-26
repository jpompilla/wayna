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
        'obs',
        'cotizacion'
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
    public function getN10Attribute(){
        return $this->nro_paxs > 10 ? 10 : $this->nro_paxs;
    }
    public function getBrochureAttribute(){
        $rpta = [];

        foreach($this->items as $i => $item){
            if($item['_group'] == 'paquete'){
                $rpta[$i]['_group'] = $item['_group'];
                $rpta[$i]['nombre'] = $item['nombre'];
                $rpta[$i]['dia'] = $item['dia'];
                $rpta[$i]['fecha'] = $item['fecha'];
                $rpta[$i]['tour'] = Servicio::find($item['tour']);
                $itemHotel = Servicio::find($item['hotel']);
                $servicio = Servicio::find($itemHotel?->items[0]['servicio']);
                $rpta[$i]['hotel'] = $servicio?->negocio;
            }
        }

        return $rpta;
    }
    public function getNroDiasAttribute(){
        $rpta = 0;
        foreach($this->items as $item)
            if($item['_group'] == 'paquete' || $item['_group'] == 'tour' || $item['_group'] == 'personalizado')
                $rpta++;
        return $rpta;
    }
    public function getPaqueteAttribute(){
        $rpta = 'No definido';

        if(!isset($this->items))
            return $rpta;
        if(count($this->items) == 0)
            return $rpta;
        
        $dias = 0;
        $ciudades = [];
        $estrellas = 0;
        $patron = '/Hotel\s+(.+?)\s*\(([^)]+)\)/';
        
        foreach($this->items as $item)
            if($item['_group'] == 'paquete' || $item['_group'] == 'tour' || $item['_group'] == 'personalizado'){
                $dias ++;

                if (preg_match($patron, $item['nombre'], $matches)) {
                    $estrellas = max($estrellas, (int)$matches[1]);
                    $ciudades[] = $matches[2];
                }
            }
        $ciudades = array_unique($ciudades);
        $ciudades = array_filter($ciudades, function($c) {
            return $c != 'Valle Sagrado' && $c != 'Aguas Calientes';
        });

        $lugares = '';
        if(count($ciudades) == 0)
            $lugares = '';
        if(count($ciudades) == 1)
            $lugares = $ciudades[0];
        if(count($ciudades) > 1){
            $ciudad = array_pop($ciudades);
            $lugares = implode(', ', $ciudades) . ' y ' . $ciudad;
        }

        $rpta = "Paquete $dias"."D $lugares ($estrellas estrellas)";

        return $rpta;
    }

    public function getTieneCotizacionAttribute(){
        return isset($this->cotizacion);
    }
    
    /*---------- Combos -------------*/
    public function getServicioOptions(){    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        $rpta = Servicio::where('negocio_id', $user->negocio_id)
                ->whereIn('tipo', ['Paquete'])
                ->whereIn('estado', ['Interno'])
                ->orderBy('nombre', 'asc')
                ->get()->lists('nombre', 'id');
        
        return $rpta;
    }
    
    public function getTourOptions(){    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        $rpta = Servicio::where('negocio_id', $user->negocio_id)
                ->whereIn('tipo', ['Tour'])
                //->whereIn('estado', ['Interno','Publicado'])
                ->get()->lists('nombre', 'id');
        
        return $rpta;
    }
    
    public function getHotelOptions(){    
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        if($this->tieneCotizacion)
            $rpta = Servicio::where('negocio_id', $user->negocio_id)
                ->whereIn('tipo', ['Hotel'])
                //->whereIn('estado', ['Interno','Publicado'])
                ->get()->lists('nombre', 'id');
        if(!$this->tieneCotizacion)
            $rpta = Servicio::where('negocio_id', $user->negocio_id)
                ->whereIn('tipo', ['Tour','Hotel','Bono','Otro'])
                //->whereIn('estado', ['Interno','Publicado'])
                ->get()->lists('nombre', 'id');
        
        return $rpta;
    }
    public function getActividadOptions(){
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        if($this->tieneCotizacion)
            $rpta = Servicio::where('negocio_id', $user->negocio_id)
                ->whereIn('tipo', ['Bono', 'Otro'])
                //->whereIn('estado', ['Interno','Publicado'])
                ->get()->lists('nombre', 'id');
        
        if(!$this->tieneCotizacion)
            $rpta = Servicio::where('negocio_id', $user->negocio_id)
                ->whereIn('tipo', ['Tour','Hotel','Bono','Otro'])
                //->whereIn('estado', ['Interno','Publicado'])
                ->get()->lists('nombre', 'id');
        
        return $rpta;
    }
    public function getAjusteOptions(){
        $rpta = [];
        
        $user = BackendAuth::getUser();
        
        $rpta = Servicio::where('negocio_id', $user->negocio_id)
                ->whereIn('tipo', ['Incremento', 'Descuento'])
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

        //trace_log($this->original['estado'].' -> '.$this->estado);
        
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
            if($this->estado == 'Cotizacion'){
                $this->generarCotizacion();
            }
        }
        else { //UPDATE
            $this->actualizarItemsAdicionalesCostos();
            if(isset($this->servicio)){
                $this->params = $this->servicio->params;
                $this->precios = $this->servicio->precios;
            }

            if($this->estado == 'Cotizacion'){
                $this->generarCotizacion();
            }
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
    
    public function filterFields($fields, $context = null){
        $user = BackendAuth::getUser();
        
        if(isset($fields->user))
            $fields->user->readOnly = !$user->hasAccess('soroche.wayna.manage_reservas');

        if($context == 'create'){
            $fields->user->value = $user->id;
        }
        if ($context == 'update'){
            $fields->servicio->readOnly = true;
            
            $fields->cotizacion->hidden = !isset($this->cotizacion);
            if (isset($fields->calculos))
                $fields->calculos->hidden = !isset($this->cotizacion);
            $fields->resumen->hidden = isset($this->cotizacion);
        }
    }
    
    /*---------- Metodos -------------*/
    public function vuelosPorFecha(){
        $rpta = [];
        foreach($this->vuelos as $item)
            $rpta[$item['fecha']][] = $item;
        return $rpta;
    }

    public function trenesPorFecha(){
        $rpta = [];
    
        if(isset($this->plan))
        foreach ($this->plan as $t => $tipoItem)        
            foreach ($tipoItem['proveedores'] as $p => $proveedorItem)
                if(mb_substr($proveedorItem['nombre'], 5) == 'Peru Rail')
                    foreach ($proveedorItem['servicios'] as $s => $servicioItem){
                        $si = $servicioItem;
                        $si['servicio'] = Servicio::find($si['concepto'])->nombre;
                        $rpta[$servicioItem['fecha']][] = $si;
                    }
                        
        return $rpta;
    }

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
                            $rpta[date('d/m/Y', strtotime($fecha))]['costo'] += empty($si['costo']) ? 0 : $si['costo'];
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

            $tour_id = 0;
            if($item['_group'] == 'paquete')
                $tour_id = $item['tour'];
            if($item['_group'] == 'adicional')
                $tour_id = $item['actividad'];
            if($item['_group'] == 'precio')
                $tour_id = $item['ajuste'];

            $tour = Servicio::find($tour_id);
            $hotel = isset($item['hotel']) ? Servicio::find($item['hotel']) : null;
                        
            if($item['_group'] == 'paquete'){
                $dia++;
                $items[$i] = $this->formatearItem('paquete', $tour, $hotel, $dia);
            }
            if($item['_group'] == 'tour'){
                $dia++;
                $items[$i] = $this->formatearItem('tour', $tour, $hotel, $dia);
                $adicionales[] = $this->formatearAdicional($tour, $hotel, $dia);
            }
            if($item['_group'] == 'personalizado'){
                $dia++;
                $items[$i] = $this->formatearItem('personalizado', $tour, $hotel, $dia);
                $costos['servicios'][] = $this->formatearCostos($tour, $hotel, $dia, $costos);
            }
            if($item['_group'] == 'adicional'){
                $nro_paxs = $item['nro_paxs'] ?? $this->nro_paxs;
                $items[$i] = $this->formatearItem('adicional', $tour, null, $dia);
                $items[$i]['nro_paxs'] = $nro_paxs;
                $adicionales[] = $this->formatearAdicional($tour, null, $dia);
            }
            if($item['_group'] == 'precio'){
                $nro_paxs = $item['cantidad'] ?? $this->nro_paxs;
                $monto = $item['monto'];
                $items[$i] = $this->formatearItem('precio', $tour, null, $dia);
                $items[$i]['cantidad'] = $nro_paxs;
                $items[$i]['monto'] = $monto;
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
        $nombre = '';
        if($tipo == 'paquete'){
            $nombre = 'Dia '.($dia).'. '.(isset($fecha)? date('(d/m): ', strtotime($fecha)):' ').$tour->nombre.(isset($hotel)? " + $hotel->nombre" : '');
            return [
                '_group' => $tipo,
                'nombre' => $nombre,
                'dia' => $dia,
                'fecha' => $fecha,
                'tour' => $tour->id,
                'hotel' => (isset($hotel) ? $hotel->id : null)
            ];
        }
        if($tipo == 'adicional'){
            $nombre = "↳ $tour->nombre";
            return [
                '_group' => $tipo,
                'nombre' => $nombre,
                'dia' => $dia,
                'fecha' => $fecha,
                'actividad' => $tour->id,
            ];
        }
        if($tipo == 'precio'){
            $nombre = "*** $tour->nombre";
            return [
                '_group' => $tipo,
                'nombre' => $nombre,
                'dia' => $dia,
                'fecha' => $fecha,
                'ajuste' => $tour->id,
            ];
        }
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
    
    private function generarCotizacion(){
        $cotizacion = [];
        
        $cotizacion['paquete']['nombre'] = $this->paquete;
        $cotizacion['paquete']['nro_paxs'] = $this->n10;
        $cotizacion['paquete']['pu'] = 0;
        $cotizacion['paquete']['precio'] = 0;
        $cotizacion['paquete']['ru'] = 0;
        $cotizacion['paquete']['reserva'] = 0;
        $cotizacion['paquete']['cmu'] = 0;
        $cotizacion['paquete']['comision'] = 0;

        $cotizacion['adelanto']['nro_paxs'] = $this->n10;
        $cotizacion['adelanto']['ru'] = 0;
        $cotizacion['adelanto']['reserva'] = 0;

        $cotizacion['comision']['nro_paxs'] = $this->n10;
        $cotizacion['comision']['cmu'] = 0;
        $cotizacion['comision']['comision'] = 0;

        $cotizacion['ajuste']['pu'] = 0;
        $cotizacion['ajuste']['precio'] = 0;
        $cotizacion['ajuste']['ru'] = 0;
        $cotizacion['ajuste']['reserva'] = 0;
        $cotizacion['ajuste']['cmu'] = 0;
        $cotizacion['ajuste']['comision'] = 0;

        if(isset($this->items))
        foreach($this->items as $i => $item){
            if($item['_group'] == 'paquete'){
                $cotizacion['items'][$i]['nombre'] = $item['nombre'];
                $cotizacion['items'][$i]['_group'] = 'paquete';
                $cotizacion['items'][$i]['dia'] = $item['dia'];
                $cotizacion['items'][$i]['fecha'] = $item['fecha'];
                $cotizacion['items'][$i]['pu'] = 0;
                $cotizacion['items'][$i]['precio'] = 0;
                $cotizacion['items'][$i]['ru'] = 0;
                $cotizacion['items'][$i]['reserva'] = 0;
                $cotizacion['items'][$i]['cmu'] = 0;
                $cotizacion['items'][$i]['comision'] = 0;

                $tour = Servicio::find($item['tour']);
                $cotizacion['items'][$i]['servicios'][0]['nombre'] = $tour->nombre;
                $cotizacion['items'][$i]['servicios'][0]['nro_paxs'] = $this->n10;
                $cotizacion['items'][$i]['pu'] += $cotizacion['items'][$i]['servicios'][0]['pu'] = $tour->precios[0][$this->n10];
                $cotizacion['items'][$i]['servicios'][0]['precio'] = $tour->precios[0][$this->n10] * $this->nro_paxs;
                $cotizacion['paquete']['pu'] += $tour->precios[0][$this->n10];

                $cotizacion['items'][$i]['ru'] += $cotizacion['items'][$i]['servicios'][0]['ru'] = $tour->params[0]['adelanto'];
                $cotizacion['items'][$i]['servicios'][0]['reserva'] = $tour->params[0]['adelanto'] * $this->nro_paxs;
                $cotizacion['paquete']['ru'] += $tour->params[0]['adelanto'];
                $cotizacion['adelanto']['ru'] += $tour->params[0]['adelanto'];                
                

                $cotizacion['items'][$i]['cmu'] += $cotizacion['items'][$i]['servicios'][0]['cmu'] = $tour->params[0]['comision'];
                $cotizacion['items'][$i]['servicios'][0]['comision'] = $tour->params[0]['comision'] * $this->nro_paxs;
                $cotizacion['paquete']['cmu'] += $tour->params[0]['comision'];                
                $cotizacion['comision']['cmu'] += $tour->params[0]['comision'];

                $hotel = Servicio::find($item['hotel']);
                if(isset($hotel)){  
                    $cotizacion['items'][$i]['servicios'][1]['nombre'] = $hotel->nombre;
                    $cotizacion['items'][$i]['servicios'][1]['nro_paxs'] = $this->n10;
                    $cotizacion['items'][$i]['pu'] += $cotizacion['items'][$i]['servicios'][1]['pu'] = $hotel->precios[0][$this->n10];
                    $cotizacion['items'][$i]['servicios'][1]['precio'] = $hotel->precios[0][$this->n10] * $this->nro_paxs;
                    $cotizacion['paquete']['pu'] += $hotel->precios[0][$this->n10];

                    $cotizacion['items'][$i]['ru'] += $cotizacion['items'][$i]['servicios'][1]['ru'] = $hotel->params[0]['adelanto'];
                    $cotizacion['items'][$i]['servicios'][1]['reserva'] = $hotel->params[0]['adelanto'] * $this->nro_paxs;
                    $cotizacion['paquete']['ru'] += $hotel->params[0]['adelanto'];
                    $cotizacion['adelanto']['ru'] += $hotel->params[0]['adelanto'];

                    $cotizacion['items'][$i]['cmu'] += $cotizacion['items'][$i]['servicios'][1]['cmu'] = $hotel->params[0]['comision'];
                    $cotizacion['items'][$i]['servicios'][1]['comision'] = $hotel->params[0]['comision'] * $this->nro_paxs;
                    $cotizacion['paquete']['cmu'] += $hotel->params[0]['comision'];
                    $cotizacion['comision']['cmu'] += $hotel->params[0]['comision'];
                }

                $cotizacion['paquete']['precio'] += $cotizacion['items'][$i]['precio'] = $cotizacion['items'][$i]['pu'] * $this->nro_paxs;
                //$cotizacion['paquete']['reserva'] = $cotizacion['adelanto']['reserva'] += $cotizacion['items'][$i]['reserva'] = $cotizacion['items'][$i]['ru'] * $this->nro_paxs;
                //$cotizacion['paquete']['comision'] = $cotizacion['comision']['comision'] += $cotizacion['items'][$i]['comision'] = $cotizacion['items'][$i]['cmu'] * $this->nro_paxs;
                $cotizacion['paquete']['reserva'] += $cotizacion['items'][$i]['reserva'] = $cotizacion['items'][$i]['ru'] * $this->nro_paxs;
                $cotizacion['paquete']['comision'] += $cotizacion['items'][$i]['comision'] = $cotizacion['items'][$i]['cmu'] * $this->nro_paxs;

                $cotizacion['adelanto']['reserva'] += $cotizacion['items'][$i]['reserva'];
                $cotizacion['comision']['comision'] += $cotizacion['items'][$i]['comision'];
            }
            if($item['_group'] == 'adicional'){
                $actividad = Servicio::find($item['actividad']);
                $cotizacion['adicionales'][$i]['nombre'] = $actividad->nombre;
                $cotizacion['adicionales'][$i]['_group'] = 'adicional';
                $cotizacion['adicionales'][$i]['dia'] = $item['dia'];
                $cotizacion['adicionales'][$i]['fecha'] = $item['fecha'];
                $cotizacion['adicionales'][$i]['nro_paxs'] = $item['nro_paxs'];                
                $cotizacion['adicionales'][$i]['pu'] = $actividad->precios[0][$item['nro_paxs']];
                $cotizacion['adicionales'][$i]['precio'] = $cotizacion['adicionales'][$i]['pu'] * $item['nro_paxs'];
                $cotizacion['adicionales'][$i]['ru'] = $actividad->params[0]['adelanto'];
                $cotizacion['adicionales'][$i]['reserva'] = $cotizacion['adicionales'][$i]['ru'] * $item['nro_paxs'];
                $cotizacion['adicionales'][$i]['cmu'] = $actividad->params[0]['comision'];
                $cotizacion['adicionales'][$i]['comision'] = $cotizacion['adicionales'][$i]['cmu'] * $item['nro_paxs'];

                $cotizacion['adelanto']['ru'] += $actividad->params[0]['adelanto'];
                $cotizacion['adelanto']['reserva'] += $actividad->params[0]['adelanto'] * $item['nro_paxs'];

                $cotizacion['comision']['cmu'] += $actividad->params[0]['comision'];
                $cotizacion['comision']['comision'] += $actividad->params[0]['comision'] * $item['nro_paxs'];
            }
            if($item['_group'] == 'precio'){
                $ajuste = Servicio::find($item['ajuste']);
                $cotizacion['ajustes'][$i]['nombre'] = $ajuste->nombre;
                $cotizacion['ajustes'][$i]['_group'] = 'precio';
                $cotizacion['ajustes'][$i]['dia'] = $item['dia'];
                $cotizacion['ajustes'][$i]['fecha'] = $item['fecha'];
                $cotizacion['ajustes'][$i]['nro_paxs'] = $item['cantidad'];              
                $cotizacion['ajustes'][$i]['pu'] = $ajuste->precios[0][$item['cantidad']] * $item['monto'];
                $cotizacion['ajustes'][$i]['precio'] = $ajuste->precios[0][$item['cantidad']] * $item['monto'] * $item['cantidad'];
                $cotizacion['ajustes'][$i]['ru'] = 0;
                $cotizacion['ajustes'][$i]['reserva'] = 0;
                $cotizacion['ajustes'][$i]['cmu'] = $ajuste->params[0]['comision'] * $item['monto'];
                $cotizacion['ajustes'][$i]['comision'] = $ajuste->params[0]['comision'] * $item['monto'] * $item['cantidad'];

                $cotizacion['ajuste']['pu'] += $ajuste->precios[0][$item['cantidad']] * $item['monto'];
                $cotizacion['ajuste']['precio'] += $ajuste->precios[0][$item['cantidad']] * $item['monto'] * $item['cantidad'];
                $cotizacion['ajuste']['ru'] += 0;
                $cotizacion['ajuste']['reserva'] += 0;
                $cotizacion['ajuste']['cmu'] += $ajuste->params[0]['comision'] * $item['monto'];
                $cotizacion['ajuste']['comision'] += $ajuste->params[0]['comision'] * $item['monto'] * $item['cantidad'];

                $cotizacion['adelanto']['ru'] += 0;
                $cotizacion['adelanto']['reserva'] += 0;

                $cotizacion['comision']['cmu'] += $ajuste->params[0]['comision'] * $item['monto'];
                $cotizacion['comision']['comision'] += $ajuste->params[0]['comision'] * $item['monto'] * $item['cantidad'];

            }
        }
        
        $this->cotizacion = $cotizacion;

        //Artificio: para mostrar el precio total del paquete para compatibilidad con al version anterior
        $precios = [[0 => 'TOTAL', 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0]];
        $precios[0][$this->n10] = $cotizacion['paquete']['pu'];
        $this->precios = $precios;

        $params = $this->params;
        $params[0]['adelanto'] = $cotizacion['adelanto']['reserva'] / $this->nro_paxs;
        $params[0]['facturable'] = $cotizacion['adelanto']['reserva'] / $this->nro_paxs;
        $params[0]['comision'] = $cotizacion['comision']['comision'] / $this->nro_paxs;
        $this->params = $params;
    }
   
    private function formatearName(){
        $name = 'Nueva Reserva';
        
        if($this->exists){
            $name = isset($this->fecha_inicio) ? date('Y-m-d', strtotime($this->fecha_inicio)) : 'Abierto';
            $name .= ' -- '.(isset($this->lider) ? $this->lider->fullname : 'Grupo de '.$this->user->fullname);
            $name .= ' x'.$this->nro_paxs;
            if($this->tieneCotizacion)
                $name .= ' - '.$this->paquete;
            if(!$this->tieneCotizacion)
                $name .= ' - '.(isset($this->servicio) ? $this->servicio->nombre : $this->paquete );
            $name .= ' - '.$this->rid;
        }
        
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
        if($this->TieneCotizacion){
            $total = $this->cotizacion['paquete']['precio'];
            if(array_key_exists('adicionales', $this->cotizacion))
            foreach($this->cotizacion['adicionales'] as $adicional)
                $total += $adicional['precio'];
            if(array_key_exists('ajustes', $this->cotizacion))
            foreach($this->cotizacion['ajustes'] as $ajuste)
                $total += $ajuste['precio'];
        }
        if(!$this->TieneCotizacion){
            $total = $this->precioTotal($this->nro_paxs > 10 ? 10 : $this->nro_paxs) * $this->nro_paxs;
        }
        $comision = $this->params[0]['comision'] * $this->nro_paxs; // pasar a los 2 escenarios
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

    public function scopePorRangoFechas($query, $inicio, $fin){
        $query->where('fecha_inicio', '<=', $fin)
              ->where('fecha_fin', '>=', $inicio)
              ->whereIn('estado', ['Abierto','Confirmado']);

        return $query;
    }
}






