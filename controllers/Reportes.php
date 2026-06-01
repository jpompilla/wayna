<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Dompdf\Dompdf;
use BackendAuth;
use DB;

class Reportes extends Controller
{
    public $implement = [];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-reportes');
    }

    public function index()
    {
        $this->pageTitle = 'Reportes';
    }

    public function proyectado()
    {
        $this->pageTitle = 'Flujo de caja proyectado';
        $user = BackendAuth::getUser();
        
        $rpta = DB::select('CALL sp_flujo_proyectado()');

        $data = [];
        foreach ($rpta as $row) {
            $data[$row->mes]['ingresos.ejecutados'] = 0;
            $data[$row->mes]['ingresos.nro_grupos'] = 0; 
            $data[$row->mes]['ingresos.nro_paxs'] = 0; 
            $data[$row->mes]['ingresos'] = 0;
            $data[$row->mes]['egresos.operativo'] = 0;
            $data[$row->mes]['egresos.comisiones'] = 0;
            $data[$row->mes]['egresos.pasarela'] = 0;
            $data[$row->mes]['egresos.impuestos'] = 0;
            $data[$row->mes]['egresos'] = 0;
            $data[$row->mes]['utilidades'] = 0;
        }
        foreach ($rpta as $row) {
            $data[$row->mes]['ingresos.ejecutados'] += $row->ingresos; 
            $data[$row->mes]['ingresos.nro_grupos'] += 1; 
            $data[$row->mes]['ingresos.nro_paxs'] += $row->nro_paxs; 
            $data[$row->mes]['ingresos'] += $row->ingresos;
            $data[$row->mes]['egresos.operativo'] += $row->costo_operativo; 
            $data[$row->mes]['egresos.comisiones'] += $row->comision; 
            $data[$row->mes]['egresos.pasarela'] += $row->izipay; 
            $data[$row->mes]['egresos.impuestos'] += $row->impuestos; 
            $data[$row->mes]['egresos'] += $row->costo_operativo + $row->comision + $row->izipay + $row->impuestos;
            $data[$row->mes]['utilidades'] += $row->ingresos - ($row->costo_operativo + $row->comision + $row->izipay + $row->impuestos);
        }

        ksort($data);
        
        $html = $this->makePartial('flujo', ['data' => $data, 'negocio' => $user->negocio]);

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        
        $dompdf->render();

        return $dompdf->stream('Flujo de caja proyectado.pdf', array("Attachment" => false));
    }
}
