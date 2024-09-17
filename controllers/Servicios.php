<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;
use Soroche\Wayna\Models\Servicio;

class Servicios extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-servicios');
    }
    public function listExtendQuery($query)
    {
        $user = BackendAuth::getUser();
        //$rpta = 
            $query
                ->join('soroche_wayna_proveedores', 'soroche_wayna_servicios.negocio_id', '=', 'soroche_wayna_proveedores.proveedor_id')
                ->where('soroche_wayna_proveedores.negocio_id',$user->negocio_id)
                ;
                //->get();
        //dd($rpta);
    }
    
    public function duplicate($id = null){
        $original = Servicio::find($id);
        $duplicado = $original->replicate();
        $duplicado->nombre = 'Copia de '.$original->nombre;
        $duplicado->save();
        return \Backend::redirect('soroche/wayna/servicios/update/' . $duplicado->id)->with('message', 'Servicio duplicado');
    }
}
