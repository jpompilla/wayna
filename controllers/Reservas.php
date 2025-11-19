<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Soroche\Wayna\Models\Reserva;
use Dompdf\Dompdf;

class Reservas extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\RelationController',
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'enter_reservas' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-reservas');
    }
    
    public function update($recordId, $context = null)
    {
        //
        // Do any custom code here
        //
        $reserva = Reserva::find($recordId);
        
        $this->pageTitle = $reserva->name;
    
        // Call the FormController behavior update() method
        return $this->asExtension('FormController')->update($recordId, $context);
    }
    
    public function invoice($recordId)
    {
        $reserva = Reserva::find($recordId);
        
        $html = $this->makePartial('invoice', ['reserva' => $reserva]);

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        
        $dompdf->render();

        return $dompdf->stream($reserva->name.'.pdf', array("Attachment" => false));

    }
    
    public function estado($recordId)
    {
        $reserva = Reserva::find($recordId);
        
        $html = $this->makePartial('estadopdf', ['reserva' => $reserva]);

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        
        $dompdf->render();

        return $dompdf->stream($reserva->name.' (estado).pdf', array("Attachment" => false));

    }
    
    public function liquidacion($recordId)
    {
        $reserva = Reserva::find($recordId);
        
        $html = $this->makePartial('liquidacion', ['reserva' => $reserva]);

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        
        $dompdf->render();

        return $dompdf->stream($reserva->name.' (liquidacion).pdf', array("Attachment" => false));

    }
    
    public function biblia(){
        $this->pageTitle = 'Seguimiento de Reservas (Biblia)';

        $tz = new \DateTimeZone('America/Lima');
        $now = new \DateTime('now', $tz);

        $fechas = [];
        for ($offset = -2; $offset <= 4; $offset++) {
            $d = (clone $now)->modify("$offset days");
            $fechas[] = $d->format('Y-m-d');
        }
        $hoy = $now->format('Y-m-d');
        $mañana = (clone $now)->modify('+1 day')->format('Y-m-d');

        $inicio = reset($fechas);
        $fin = end($fechas);

        $reservas = Reserva::porRangoFechas($inicio, $fin)->get();

        BackendMenu::setContext('Soroche.Wayna', 'menu-seguimiento');

        return $this->makePartial('biblia', ['fechas' => $fechas, 'reservas' => $reservas, 'hoy' => $hoy, 'mañana' => $mañana]);
    }
}
