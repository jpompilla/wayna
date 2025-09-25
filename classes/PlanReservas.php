<?php namespace Soroche\Wayna\Classes;

use Soroche\Wayna\Models\Servicio;
use Soroche\Wayna\Models\Reserva;

class PlanReservas
{
    public array $plan = [];

    public function __construct(
        private $reserva,
    )
    {   
    }

    public static function generar($reserva){
        
        $rpta = new self($reserva);
        $rpta->plan['Entradas'] = ['nombre' => '1234 Entradas'];
        $rpta->plan['Alojamiento'] = ['nombre' => '1234 Alojamiento'];
        $rpta->plan['Trenes y transporte'] = ['nombre' => '1234 Trenes y transporte'];
        $rpta->plan['Tour Endoce'] = ['nombre' => '1234 Tour Endoce'];

        foreach($reserva->items as $item){
            if(isset($item['tour'])){
                $tour = Servicio::find($item['tour']);
                foreach($tour->items as $servicioitem)
                    $rpta->agregar($servicioitem['servicio'], $item['fecha']);
            }
            if(isset($item['hotel'])){
                $hotel = Servicio::find($item['hotel']);
                if(isset($hotel))
                    foreach($hotel->items as $servicioitem)
                        $rpta->agregar($servicioitem['servicio'], $item['fecha']);
            }
        }

        return $rpta;
    }

    public static function cargar($reserva){
        $rpta = new self($reserva);
        $rpta->plan = $reserva->plan;
        return $rpta;
    }

    /* -------------Metodos Publicos ------------- */
    public function agregar($servicio_id, $fecha)
    {
        $servicio = Servicio::find($servicio_id);
        $tipo = $servicio->tipo;
        $negocio_id = $servicio->negocio->id;
        $negocio = $servicio->negocio->nombre;
        $capacidad = $servicio->capacidad;
        $costos = $servicio->costos[0];
        $contacto = $servicio->negocio->contacto;
        $nro_paxs = $this->reserva->nro_paxs;

        //Tipo: Nombre
        $this->plan[$tipo]['nombre'] = '1234 '.$tipo;
        
        //Proveedor: Grupo
        $this->plan[$tipo]['proveedores'][$negocio_id]['_group'] = $this->toGrupo($tipo);
        //Proveedor: Nombre
        $this->plan[$tipo]['proveedores'][$negocio_id]['nombre'] = '1234 '.$negocio;
        //Proveedor: Servicios[]
        if ($tipo == 'Alojamiento'){
            $this->plan[$tipo]['proveedores'][$negocio_id]['fechas'][] = $fecha;
            $this->plan[$tipo]['proveedores'][$negocio_id]['servicios'][$servicio_id] = $this->toFila(null, $servicio_id, $nro_paxs, $capacidad, $costos);
        } else
            $this->plan[$tipo]['proveedores'][$negocio_id]['servicios'][] = $this->toFila($fecha, $servicio_id, $nro_paxs, $capacidad, $costos);
        //Proveedor: Estados[]
        $this->plan[$tipo]['proveedores'][$negocio_id]['estados'] = $this->toEstados($contacto);
    }

    public function render(): array{
        $this->formatearEstados();
        $this->actualizarCostosYContactos();
        $this->generarPlantillas();

        return $this->plan;
    }

    /* -------------Metodos Privados ------------- */
    private function toGrupo($tipo){
        return match ($tipo) {
            'Entradas' => 'entradas',
            'Alojamiento' => 'alojamientos',
            'Trenes y transporte' => 'trenes',
            default => 'general',
        };
    }
    private function toFila($fecha, $servicio_id, $nro_paxs, $capacidad, $costos){
        if($fecha === null)
            return [
                'cantidad' => ceil($nro_paxs / $capacidad),
                'concepto' => $servicio_id,
                'cu' => $costos[$nro_paxs>10 ? 10 : $nro_paxs] / ceil($nro_paxs / $capacidad),
                'costo' => $costos[$nro_paxs>10 ? 10 : $nro_paxs],
            ];
        else
            return [
                'fecha' => date('d/m/Y', strtotime($fecha)),
                'cantidad' => ceil($nro_paxs / $capacidad),
                'concepto' => $servicio_id,
                'cu' => $costos[$nro_paxs>10 ? 10 : $nro_paxs] / ceil($nro_paxs / $capacidad),
                'costo' => $costos[$nro_paxs>10 ? 10 : $nro_paxs],
            ];
    }
    private function toEstados($contacto){
        return [
            0 => [
                '_group' => 'requerimiento',
                'nombre' => 0,
                'contacto' => $contacto,],
            1 => [
                '_group' => 'confirmacion',
                'nombre' => 0,],
            2 => [
                '_group' => 'pagado',
                'nombre' => 0,],
            3 => [
                '_group' => 'facturado',
                'nombre' => 0,],
        ];
    }

    private function formatearEstados(){
        foreach($this->plan as $t => $tipo){
            $nombre = mb_substr($tipo['nombre'], 5);
            list($estado, $checks) = $this->checksProveedores($t, $tipo['proveedores']);
            $this->plan[$t]['nombre'] = $estado.' '.$nombre;
        }

        $this->reserva->avance = $this->avanceReserva();
    }

    private function avanceReserva(){
        $rpta = '';
        $mapi = '';
        $hoteles = '';
        $trenes = '';
        $tours = '';
        
        foreach($this->plan as $t => $tipo){
            switch ((mb_substr($tipo['nombre'], 5))) {
                case 'Alojamiento':
                    $hoteles = mb_substr($tipo['nombre'], 1, 1);
                    break;
                case 'Tour Endoce':
                    $tours = mb_substr($tipo['nombre'], 1, 1);
                    break;
                default:
                    foreach($tipo['proveedores'] as $p => $proveedor){
                        if(mb_substr($proveedor['nombre'], 5) == 'TuBoleto Cultura')
                            $mapi = mb_substr($proveedor['nombre'], 2, 1);
                        if(mb_substr($proveedor['nombre'], 5) == 'Peru Rail')
                            $trenes = mb_substr($proveedor['nombre'], 3, 1);
                    }
            }   
        }

        return $mapi.$hoteles.$trenes.$tours;
    }
    private function checksProveedores($t, $proveedores){
        $tipo = '';
        $valores = [0,0,0,0];
        foreach($proveedores as $p => $proveedor){
            $nombre = mb_substr($this->plan[$t]['proveedores'][$p]['nombre'], 5);
            list($estado, $checks) = $this->checksEstados($proveedor['estados']);
            $this->plan[$t]['proveedores'][$p]['nombre'] = $estado.' '.$nombre;
            foreach($checks as $ch => $check)
                $valores[$ch] += $check;
        }
        $nro_proveedores = count($proveedores);
        foreach($valores as $v => $valor){            
            $valores[$v] = floor($valores[$v] / ($nro_proveedores > 0 ? $nro_proveedores : 1));
            $tipo .= $this->getChecks($valores[$v]);
        }

        return [$tipo, $valores];
    }
    private function checksEstados($estados){
        $provedor = '';
        $valores = [];
        foreach($estados as $e => $estado){
            $provedor .= $this->getChecks($estado['nombre']);
            $valores[] = $estado['nombre'];
        }
        return [$provedor, $valores];
    }
    private function getChecks($i){
        $rpta = '';
        
        if($i == 0) $rpta = '🟧';
        if($i == 1) $rpta = '🟨';
        if($i > 1) $rpta = '✅';
        
        return $rpta;
    }

    private function actualizarCostosYContactos(){
        foreach($this->plan as $t => $tipo){
            foreach($tipo['proveedores'] as $p => $proveedor){
                $prov = null;
                foreach($proveedor['servicios'] as $s => $servicio){
                    $serv = Servicio::find($servicio['concepto']);
                    if($prov === null)
                        $prov = $serv->negocio;
                    $costos = $serv->costos[0];
                    $nro_paxs = $this->reserva->nro_paxs;
                    $capacidad = $serv->capacidad;
                    $cantidad = $servicio['cantidad'];
                    $pu = empty($servicio['pu']) ? 0 : $servicio['pu'];
                    
                    //$this->plan[$t]['proveedores'][$p]['servicios'][$s]['cantidad'] = $cantidad;
                    $this->plan[$t]['proveedores'][$p]['servicios'][$s]['cu'] = $costos[$nro_paxs>10 ? 10 : $nro_paxs] / ceil($nro_paxs / $capacidad);
                    $this->plan[$t]['proveedores'][$p]['servicios'][$s]['costo'] = $costos[$nro_paxs>10 ? 10 : $nro_paxs];
                    if(!empty($servicio['pu']))
                        if(array_key_exists('tc', $servicio) && !empty($servicio['tc']) && is_numeric($servicio['tc']) && $servicio['tc'] > 0)
                            $this->plan[$t]['proveedores'][$p]['servicios'][$s]['pago'] = round($pu * $cantidad / $servicio['tc'],2);
                        else
                            $this->plan[$t]['proveedores'][$p]['servicios'][$s]['pago'] = $pu * $cantidad;
                }
                if($prov !== null){
                    $this->plan[$t]['proveedores'][$p]['nombre'] = mb_substr($proveedor['nombre'], 0, 5).$prov->nombre;
                    $this->plan[$t]['proveedores'][$p]['estados'][0]['contacto'] = $prov->contacto;
                }

                if(array_key_exists('pagos', $proveedor['estados'][2]) && is_array($proveedor['estados'][2]['pagos']))
                foreach($proveedor['estados'][2]['pagos'] as $i => $pago){
                    if(array_key_exists('tc', $pago) && !empty($pago['tc']) && is_numeric($pago['tc']) && $pago['tc'] > 0)
                        $this->plan[$t]['proveedores'][$p]['estados'][2]['pagos'][$i]['monto'] = round((empty($pago['soles']) ? 0: $pago['soles']) / $pago['tc'],2);
                        $this->plan[$t]['proveedores'][$p]['estados'][2]['pagos'][$i]['pagopath'] = $pago['file'];
                }

                if(array_key_exists('comprobantes', $proveedor['estados'][3]) && is_array($proveedor['estados'][3]['comprobantes']))
                foreach($proveedor['estados'][3]['comprobantes'] as $i => $comprobante){
                        $this->plan[$t]['proveedores'][$p]['estados'][3]['comprobantes'][$i]['filepath'] = $comprobante['file'];
                }
            }
        }
    }

    private function generarPlantillas(){
        foreach($this->plan as $t => $tipo){
            foreach($tipo['proveedores'] as $p => $proveedor){
                if(mb_substr($tipo['nombre'], 5) == 'Alojamiento'){
                    $data = [
                        'hotel' => mb_substr($proveedor['nombre'], 5),
                        'habitaciones' => $this->renderHabitaciones($proveedor['servicios']),
                        'estadia' => $this->renderEstadia($proveedor['fechas']),
                        'paxs' => $this->renderPaxs(),
                    ];
                    $this->plan[$t]['proveedores'][$p]['estados'][0]['req'] = $this->renderTemplate($this->plantillaHotel, $data);
                }
                if(mb_substr($proveedor['nombre'], 5) == 'Peru Rail'){
                    $data = [
                        'trenes' => $this->renderTrenes($proveedor['servicios']),
                        'paxs' => $this->renderPaxs(),
                    ];
                    $this->plan[$t]['proveedores'][$p]['estados'][0]['req'] = $this->renderTemplate($this->plantillaTrenes, $data);
                }
                if(mb_substr($tipo['nombre'], 5) == 'Tour Endoce' || mb_substr($tipo['nombre'], 5) == 'Traslado' || mb_substr($tipo['nombre'], 5) == 'Alimentacion'){
                    $plantila = '';
                    foreach($proveedor['servicios'] as $s => $servicio){
                        $serv = Servicio::find($servicio['concepto']);
                        $data = [
                            'nombre' => $serv->nombre,
                            'fecha' => $servicio['fecha'],
                            'nro' => count($this->reserva->paxs),
                            'paxs' => $this->renderPaxs(),
                            'hoteles' => $this->renderHoteles(),
                            'contacto' => $this->renderContacto(),
                            'vuelos' => $this->renderVuelos(),
                            'trenes' => $this->renderTrenes(null),
                            'entradas' => $this->renderEntradas(),
                            'obs' => $this->renderObs(),
                        ];
                        $plantila .= $this->renderTemplate($this->plantillaTour, $data);
                    }
                    $this->plan[$t]['proveedores'][$p]['estados'][0]['req'] = $plantila;
                }
            }
        }
    }

    private function renderTemplate($template, $data){
        foreach ($data as $key => $value) {
            $template = str_replace("{{".$key."}}", $value, $template);
        }
        return $template;
    }
    private function renderHabitaciones($servicios){
        $rpta = '';
        foreach ($servicios as $i => $item) {
            $servicio = Servicio::find($item['concepto']);
            $rpta .= ' - '.sprintf('%02d', $item['cantidad']).' '.$servicio->nombre. PHP_EOL;
        }
        return $rpta;
    }
    private function renderEstadia($fechas){
        $rpta = '';
        $fi = null;
        $ff = null;
        $nro = 0;
        for($i=0; $i < count($fechas); $i++){
            if(!isset($fi))
                $fi = $fechas[$i];
            if($i+1 < count($fechas) && $fechas[$i+1] == date('Y-m-d', strtotime($fechas[$i]. " + 1 days"))){
                $nro++;
            }
            else{
                $nro++;
                $ff = date('Y-m-d', strtotime($fechas[$i]. " + 1 days"));
                $rpta .= ' - '.date('d/m/Y', strtotime($fi)).' al '. date('d/m/Y', strtotime($ff)). ' (' . sprintf('%02d', $nro).' noches)' . PHP_EOL;
                $fi = null;
                $nro = 0;
            }
        }
        return $rpta;
    }
    private function renderPaxs(){
        $rpta = '';
        foreach ($this->reserva->paxs as $p => $pax) {
            $rpta .= ' - '.$pax->fullname.' ('.$pax->nacionalidad.') Pas: '.$pax->pasaporte_nro.' FN: '.date('d/m/Y', strtotime($pax->fecha_nacimiento)).' ('.$pax->edad.')'. PHP_EOL;
        }
        return $rpta;
    }
    private function renderTrenes($servicios){
        if($servicios == null)
            foreach ($this->plan as $t => $tipo) {
                foreach ($tipo['proveedores'] as $p => $proveedor) {
                    if(mb_substr($proveedor['nombre'], 5) == 'Peru Rail'){
                        $servicios = $proveedor['servicios'];
                        break 2;
                    }
                }
            }

        $rpta = '';
        if(isset($servicios))
        foreach ($servicios as $i => $item) {
            $servicio = Servicio::find($item['concepto']);
            $rpta .= ' - '.$item['fecha'].': '.$servicio->nombre.' '.(isset($item['salida'])?$item['salida']:'ND').'->'.(isset($item['llegada'])?$item['llegada']:'ND').PHP_EOL;
        }
        return $rpta;
    }
    private function renderHoteles(){
        $hoteles = [];
        foreach ($this->plan as $t => $tipo) {
            if(mb_substr($tipo['nombre'], 5) == 'Alojamiento'){
                $hoteles = $tipo['proveedores'];
                break;
            }
        }

        $rpta = '';
        foreach ($hoteles as $hotel) {
            $h = array_key_first($hotel['servicios']);
            $hotel_id = $hotel['servicios'][$h]['concepto'];
            $servicio = Servicio::find($hotel_id);
            $rpta .= ' - '.$servicio->negocio->nombre.': _'.$servicio->negocio->direccion.'_'.PHP_EOL;
        }
        return $rpta;
    }
    private function renderContacto(){
        $rpta = $this->reserva->lider->lidercontacto.PHP_EOL;        
        return $rpta;
    }
    private function renderVuelos(){
        $rpta = '';
        foreach ($this->reserva->vuelos as $vuelo) 
            if(array_key_exists('fecha', $vuelo))
                $rpta .= ' - '.$vuelo['fecha'].': '.$vuelo['ruta'].' '.$vuelo['aerolinea'].' ('.$vuelo['vuelo'].') '.$vuelo['salida'].'->'.$vuelo['llegada'].PHP_EOL;
        
        return $rpta;
    }
    private function renderEntradas(){
        $servicios = [];
        foreach ($this->plan as $t => $tipo) {
            foreach ($tipo['proveedores'] as $p => $proveedor) {
                if(mb_substr($proveedor['nombre'], 5) == 'TuBoleto Cultura'){
                    $servicios = $proveedor['servicios'];
                    break 2;
                }
            }
        }
        $rpta = '';
        foreach ($servicios as $i => $item) {
            $servicio = Servicio::find($item['concepto']);
            $rpta .= ' - '.$item['fecha'].': '.$servicio->nombre.' '.(isset($item['hora'])?$item['hora']:'ND').PHP_EOL;
        }
        return $rpta;
    }
    private function renderObs(){
        $rpta = '';
        
        if(array_key_exists('salud', $this->reserva->obs) && !empty($this->reserva->obs['salud']))
            $rpta.= $this->reserva->obs['salud'] . PHP_EOL;
        if(array_key_exists('particulares', $this->reserva->obs) && !empty($this->reserva->obs['particulares']))
            $rpta.= $this->reserva->obs['particulares'] . PHP_EOL;
        if(empty($rpta))
            $rpta = 'Ninguna';
        
        return $rpta;
    }


    private string $plantillaHotel = '
Buen día,

Previo un cordial saludo, para solicitar la siguiente reserva:

{{hotel}}
---------------------
Habitaciones:
{{habitaciones}}
Estadía:
{{estadia}}
Rooming List:
{{paxs}}
Agradecidos de antemano por su ayuda, quedamos atentos a su respuesta.

Atentamente.';

    private string $plantillaTrenes = '
Buen día,

Previo un cordial saludo, para solicitar la siguiente reserva:

Tramos:
-------
{{trenes}}
Lista de pasajeros:
------------------
{{paxs}}
Datos para Factura:
------------------
RUC: 20612964522
Razón Social: Machupicchu Plus SAC
Dirección: Av Las Flores 2023, San Sebastian, Cusco

Agradecidos de antemano por su ayuda, quedamos atentos a su respuesta.

Atentamente.';

    private string $plantillaTour = '
*Tour/Servicio:* {{nombre}}
*Fecha:* {{fecha}}
*Pasajeros:* {{nro}}
{{paxs}}*Alojamiento:*
{{hoteles}}*Idioma:* Español
*Contacto:*
{{contacto}}*Vuelos:*
{{vuelos}}*Trenes:*
{{trenes}}Entradas:*
{{entradas}}*Observaciones:*
{{obs}}
----------------

';
}