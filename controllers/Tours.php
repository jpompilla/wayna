<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;
use Soroche\Wayna\Models\Servicio;

class Tours extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_productos' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-tours');
    }
    
    public function listExtendQuery($query)
    {
        $user = BackendAuth::getUser();
        //$rpta = 
            $query
                ->where('negocio_id', $user->negocio_id)
                ->where('tipo', 'Tour')
                ;
                //->get();
        //dd($rpta);
    }
    
    public function duplicate($id = null){
        $original = Servicio::find($id);
        $duplicado = $original->replicate();
        $duplicado->nombre = 'Copia de '.$original->nombre;
        $duplicado->save();
        return \Backend::redirect('soroche/wayna/tours/update/' . $duplicado->id)->with('message', 'Servicio duplicado');
    }
}
