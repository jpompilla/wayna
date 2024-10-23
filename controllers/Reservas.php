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
}
